<?php
require_once __DIR__ . '/../includes/layout.php';
require_login();
$pageTitle = 'ໜ້າຂາຍ (POS)';

$cats = $connect->query("SELECT * FROM categories ORDER BY name");
$catFilter = (int)($_GET['cat'] ?? 0);
$search = trim($_GET['q'] ?? '');

$where = ['p.status = 1'];
$types = '';
$params = [];
if ($catFilter > 0) { $where[] = 'p.category_id = ?'; $types .= 'i'; $params[] = $catFilter; }
if ($search !== '') { $where[] = 'p.name LIKE ?'; $types .= 's'; $params[] = "%$search%"; }
$sql = "SELECT p.*, c.name AS category_name FROM products p
        LEFT JOIN categories c ON c.id = p.category_id
        WHERE " . implode(' AND ', $where) . "
        ORDER BY p.name";
$stmt = $connect->prepare($sql);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$prods = $stmt->get_result();

layout_head($pageTitle);
?>
<?php flash_banner(); ?>
<div class="row g-3">
    <div class="col-lg-8 col-md-7">
        <div class="card">
            <div class="card-header">
                <form method="get" class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <div class="search-input-wrap">
                            <span class="search-icon">
                                <svg width="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                </svg>
                            </span>
                            <input type="search" name="q" class="form-control" placeholder="ຄົ້ນຫາສິນຄ້າ..." value="<?= e($search) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="cat" class="form-select" onchange="this.form.submit()">
                            <option value="0">— ທຸກໝວດໝູ່ —</option>
                            <?php while ($c = $cats->fetch_assoc()): ?>
                                <option value="<?= (int)$c['id'] ?>" <?= $catFilter === (int)$c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button class="btn btn-soft-primary">ຄົ້ນຫາ</button>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <?php if ($prods->num_rows === 0): ?>
                    <?= empty_state('ບໍ່ພົບສິນຄ້າ', 'ລອງປ່ຽນຄຳຄົ້ນຫາ ຫຼື ໝວດໝູ່', '🔍') ?>
                <?php else: ?>
                <div class="row g-3">
                <?php while ($p = $prods->fetch_assoc()):
                    $out = $p['stock'] <= 0;
                    $low = !$out && $p['stock'] <= $p['low_stock_threshold'];
                ?>
                    <div class="col-6 col-md-4 col-xl-3">
                        <div class="card product-card <?= $out ? 'out-of-stock' : '' ?> mb-0 position-relative"
                            data-id="<?= (int)$p['id'] ?>"
                            data-name="<?= e($p['name']) ?>"
                            data-price="<?= (float)$p['price'] ?>"
                            data-stock="<?= (int)$p['stock'] ?>"
                            onclick="<?= $out ? '' : 'addToCart(this)' ?>">
                            <?= product_avatar($p, 'lg') ?>
                            <?php if ($p['category_name']): ?>
                                <span class="badge bg-white text-dark position-absolute" style="top:8px;left:8px;font-weight:500;box-shadow:0 1px 4px rgba(0,0,0,.08)">
                                    <?= e($p['category_name']) ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($out): ?>
                                <span class="badge bg-danger position-absolute" style="top:8px;right:8px">ໝົດ</span>
                            <?php elseif ($low): ?>
                                <span class="badge bg-warning text-dark position-absolute" style="top:8px;right:8px">ໃກ້ໝົດ</span>
                            <?php endif; ?>
                            <div class="card-body p-2">
                                <div class="fw-semibold text-truncate" title="<?= e($p['name']) ?>"><?= e($p['name']) ?></div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-primary fw-bold"><?= money($p['price']) ?></span>
                                    <small class="text-muted">ສະຕັອກ <?= (int)$p['stock'] ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="cart-drawer-backdrop d-md-none" id="cartDrawerBackdrop" onclick="closeCartDrawer()"></div>
    <button type="button" class="cart-pill d-md-none" id="cartPillBtn" onclick="openCartDrawer()">
        <span class="cart-pill-icon">
            <svg width="22" viewBox="0 0 24 24" fill="currentColor"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12L8.1 13h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0020 4H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
            <span class="cart-pill-badge" id="cartPillCount">0</span>
        </span>
        <span class="cart-pill-label">ເບິ່ງກະຕ່າ</span>
        <span class="cart-pill-total" id="cartPillTotal">0 ກີບ</span>
    </button>

    <div class="col-lg-4 col-md-5" id="cartColumn">
        <div class="card cart-card cart-sticky">
            <div class="card-header cart-header">
                <div class="d-flex align-items-center">
                    <svg width="20" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                        <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12L8.1 13h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0020 4H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                    </svg>
                    <h5 class="mb-0 text-white">ກະຕ່າສິນຄ້າ</h5>
                    <span class="badge bg-white text-primary ms-auto" id="cartCount">0</span>
                    <button type="button" class="btn-close-cart d-md-none ms-2" onclick="closeCartDrawer()" aria-label="ປິດ">&times;</button>
                </div>
            </div>
            <div class="card-body p-2">
                <form id="cartForm" method="post" action="../controller/sales.php" onsubmit="return prepareSubmit()">
                    <input type="hidden" name="items" id="itemsInput">
                    <input type="hidden" name="action" value="checkout">
                    <div class="table-responsive" style="max-height:42vh">
                        <table class="table table-sm cart-table mb-0">
                            <tbody id="cartBody">
                                <tr id="cartEmpty"><td colspan="4" class="py-4">
                                    <div class="empty-state text-center">
                                        <svg class="empty-cart-svg" width="68" height="68" viewBox="0 0 64 64" fill="none">
                                            <path d="M14 18h4l4 26h26l4-20H22" stroke="#cbd5e1" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                            <circle cx="26" cy="52" r="3" fill="#cbd5e1"/>
                                            <circle cx="46" cy="52" r="3" fill="#cbd5e1"/>
                                            <path d="M30 24v8M38 24v8M34 20v12" stroke="#94a3b8" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                        <div class="empty-title mt-2">ກະຕ່າວ່າງ</div>
                                        <div class="empty-sub text-muted small">ກົດທີ່ສິນຄ້າເພື່ອເພີ່ມ</div>
                                    </div>
                                </td></tr>
                            </tbody>
                        </table>
                    </div>
                    <hr class="my-2">
                    <div class="px-2">
                        <div class="d-flex justify-content-between align-items-baseline mb-2">
                            <span class="text-muted">ລວມທັງໝົດ</span>
                            <span class="fs-4 fw-bold text-primary" id="grandTotal">0 ກີບ</span>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">ຮັບເງິນຈາກລູກຄ້າ</label>
                            <div class="search-input-wrap">
                                <span class="search-icon" style="font-weight:600">₭</span>
                                <input type="number" id="paidInput" name="paid" class="form-control" min="0" step="100" placeholder="ປ້ອນຈຳນວນເງິນທີ່ໄດ້ຮັບ..." value="">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">ເງິນທອນ</span>
                            <span class="fw-bold" id="changeAmount">0 ກີບ</span>
                        </div>
                        <button type="submit" id="checkoutBtn" class="btn btn-primary w-100 btn-checkout" disabled>
                            <span class="checkout-label">+ ເລືອກສິນຄ້າເພື່ອເລີ່ມ</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.cart-header {
    background: var(--brand) !important; color: #fff;
    border-radius: 14px 14px 0 0 !important;
}
.cart-header h5 { color: #fff !important; }
.btn-close-cart {
    background: rgba(255,255,255,.2); border: 0; color: #fff;
    width: 28px; height: 28px; border-radius: 50%;
    font-size: 1.25rem; line-height: 1; padding: 0;
    display: flex; align-items: center; justify-content: center;
}
.btn-close-cart:hover { background: rgba(255,255,255,.35); }
.cart-card .btn-checkout {
    padding: .85rem 1rem; font-size: 1rem; font-weight: 600;
    box-shadow: 0 4px 14px rgba(94, 114, 228, .25);
    transition: all .15s;
}
.cart-card .btn-checkout:disabled {
    cursor: not-allowed; opacity: 1;
    background: #e2e6ef !important; border-color: #e2e6ef !important;
    color: #94a3b8 !important; box-shadow: none;
}
.cart-card .btn-checkout:not(:disabled):hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(94, 114, 228, .35); }
.cart-table tbody tr:hover > * { background: transparent !important; }
.cart-table > :not(caption) > * > * { padding: .55rem .5rem; }
.empty-cart-svg { display: block; margin: 0 auto; }

/* desktop / tablet sticky */
@media (min-width: 768px) {
    .cart-sticky { position: sticky; top: 80px; }
}

/* mobile cart pill (floating bottom button to open cart drawer) */
.cart-pill {
    display: none;
    position: fixed;
    bottom: 1rem; left: 1rem; right: 1rem;
    z-index: 1035;
    background: var(--brand); color: #fff;
    border: 0; border-radius: 999px;
    padding: .8rem 1.1rem;
    box-shadow: 0 8px 24px rgba(94, 114, 228, .35), 0 2px 6px rgba(0,0,0,.08);
    align-items: center; gap: .75rem;
    font-weight: 600;
}
.cart-pill.show { display: flex; }
.cart-pill .cart-pill-icon { position: relative; display: flex; align-items: center; }
.cart-pill .cart-pill-badge {
    position: absolute; top: -6px; right: -8px;
    background: #fff; color: var(--brand);
    font-size: .68rem; font-weight: 700;
    padding: 0 .4rem; border-radius: 999px; min-width: 18px; text-align: center;
}
.cart-pill .cart-pill-label { flex: 1; text-align: left; }
.cart-pill .cart-pill-total { font-size: 1rem; }

/* mobile: cart column becomes bottom-sheet drawer */
@media (max-width: 767.98px) {
    #cartColumn {
        position: fixed; bottom: 0; left: 0; right: 0; top: auto;
        z-index: 1055;
        max-height: 88vh; overflow-y: auto;
        transform: translateY(100%);
        transition: transform .3s cubic-bezier(.16,1,.3,1);
        padding: 0;
    }
    #cartColumn.drawer-open { transform: translateY(0); }
    #cartColumn .cart-card {
        margin: 0;
        border-radius: 18px 18px 0 0;
        box-shadow: 0 -8px 30px rgba(15, 23, 42, .25);
    }
    #cartColumn .cart-header { border-radius: 18px 18px 0 0 !important; }
    #cartColumn .cart-card .table-responsive { max-height: 38vh; }
}
.cart-drawer-backdrop {
    position: fixed; inset: 0;
    background: rgba(15, 23, 42, .45);
    z-index: 1045;
    opacity: 0; pointer-events: none;
    transition: opacity .25s ease;
}
.cart-drawer-backdrop.show { opacity: 1; pointer-events: auto; }
</style>

<script>
const cart = new Map();

function fmt(n) { return Math.round(n).toLocaleString() + ' ກີບ'; }

function addToCart(el) {
    const id = el.dataset.id;
    const stock = parseInt(el.dataset.stock, 10);
    const item = cart.get(id) || { id, name: el.dataset.name, price: parseFloat(el.dataset.price), qty: 0, stock };
    if (item.qty + 1 > stock) { showToast('warning', 'ສະຕັອກບໍ່ພຽງພໍ'); return; }
    item.qty += 1;
    cart.set(id, item);
    render();
}

function changeQty(id, delta) {
    const item = cart.get(id);
    if (!item) return;
    const newQty = item.qty + delta;
    if (newQty < 1) { cart.delete(id); render(); return; }
    if (newQty > item.stock) { showToast('warning', 'ສະຕັອກບໍ່ພຽງພໍ'); return; }
    item.qty = newQty;
    render();
}

function removeItem(id) { cart.delete(id); render(); }

const EMPTY_CART_HTML = `<tr id="cartEmpty"><td colspan="4" class="py-4">
  <div class="empty-state text-center">
    <svg class="empty-cart-svg" width="68" height="68" viewBox="0 0 64 64" fill="none">
      <path d="M14 18h4l4 26h26l4-20H22" stroke="#cbd5e1" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
      <circle cx="26" cy="52" r="3" fill="#cbd5e1"/>
      <circle cx="46" cy="52" r="3" fill="#cbd5e1"/>
      <path d="M30 24v8M38 24v8M34 20v12" stroke="#94a3b8" stroke-width="2" stroke-linecap="round"/>
    </svg>
    <div class="empty-title mt-2">ກະຕ່າວ່າງ</div>
    <div class="empty-sub text-muted small">ກົດທີ່ສິນຄ້າເພື່ອເພີ່ມ</div>
  </div>
</td></tr>`;

function syncCartPill(totalCount, total) {
    const pill = document.getElementById('cartPillBtn');
    if (!pill) return;
    if (totalCount > 0) pill.classList.add('show'); else pill.classList.remove('show');
    document.getElementById('cartPillCount').textContent = totalCount;
    document.getElementById('cartPillTotal').textContent = fmt(total);
}
function openCartDrawer() {
    document.getElementById('cartColumn').classList.add('drawer-open');
    document.getElementById('cartDrawerBackdrop').classList.add('show');
    document.body.style.overflow = 'hidden';
}
function closeCartDrawer() {
    document.getElementById('cartColumn').classList.remove('drawer-open');
    document.getElementById('cartDrawerBackdrop').classList.remove('show');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && document.getElementById('cartColumn').classList.contains('drawer-open')) closeCartDrawer();
});

function render() {
    const body = document.getElementById('cartBody');
    const totalCount = [...cart.values()].reduce((a, b) => a + b.qty, 0);
    document.getElementById('cartCount').textContent = totalCount;
    const btn = document.getElementById('checkoutBtn');
    const lbl = btn.querySelector('.checkout-label');
    if (cart.size === 0) {
        body.innerHTML = EMPTY_CART_HTML;
        document.getElementById('grandTotal').textContent = '0 ກີບ';
        btn.disabled = true;
        if (lbl) lbl.textContent = '+ ເລືອກສິນຄ້າເພື່ອເລີ່ມ';
        syncCartPill(0, 0);
        updateChange();
        return;
    }
    let total = 0;
    let html = '';
    for (const item of cart.values()) {
        const sub = item.price * item.qty;
        total += sub;
        html += `<tr>
            <td><div class="small fw-semibold">${item.name}</div><div class="text-muted small">${fmt(item.price)}</div></td>
            <td class="text-center" style="width:110px">
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary" onclick="changeQty('${item.id}',-1)">−</button>
                    <span class="btn btn-outline-secondary disabled" style="min-width:32px">${item.qty}</span>
                    <button type="button" class="btn btn-outline-secondary" onclick="changeQty('${item.id}',1)">+</button>
                </div>
            </td>
            <td class="text-end fw-semibold">${fmt(sub)}</td>
            <td style="width:24px"><button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeItem('${item.id}')">✕</button></td>
        </tr>`;
    }
    body.innerHTML = html;
    document.getElementById('grandTotal').textContent = fmt(total);
    btn.disabled = false;
    if (lbl) lbl.textContent = '✓ ບັນທຶກການຂາຍ ' + fmt(total);
    syncCartPill(totalCount, total);
    updateChange();
}

function getTotal() {
    let t = 0;
    for (const i of cart.values()) t += i.price * i.qty;
    return t;
}

function updateChange() {
    const paid = parseFloat(document.getElementById('paidInput').value) || 0;
    const change = paid - getTotal();
    const el = document.getElementById('changeAmount');
    el.textContent = fmt(Math.max(0, change));
    el.className = 'fw-bold ' + (change < 0 ? 'text-danger' : 'text-success');
}

document.getElementById('paidInput').addEventListener('input', updateChange);

async function doSubmit() {
    if (cart.size === 0) { showToast('warning', 'ກະຕ່າວ່າງ'); return; }
    const paid = parseFloat(document.getElementById('paidInput').value) || 0;
    if (paid < getTotal()) {
        const ok = await showConfirm({
            title: 'ເງິນບໍ່ພຽງພໍ',
            message: 'ເງິນຮັບໜ້ອຍກວ່າຍອດ ' + fmt(getTotal() - paid) + '. ດຳເນີນຕໍ່?',
            confirmText: 'ດຳເນີນຕໍ່',
            variant: 'warning'
        });
        if (!ok) return;
    }
    const items = [...cart.values()].map(i => ({id: parseInt(i.id), qty: i.qty, price: i.price, name: i.name}));
    document.getElementById('itemsInput').value = JSON.stringify(items);
    const form = document.getElementById('cartForm');
    form.dataset._confirmed = '1';  // bypass global confirm handler
    form.submit();
}

function prepareSubmit() {
    doSubmit();
    return false;  // always cancel native submit; doSubmit() programmatically submits when ready
}
</script>
<?php layout_foot(); ?>
