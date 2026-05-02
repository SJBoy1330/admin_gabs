@extends('layouts.admin.main')

@push('styles')
<style>
    :root { --primary-blue: #009ef7; --soft-blue: #f1faff; }
    .customer-avatar { 
        width: 40px; height: 40px; 
        background-color: var(--soft-blue); 
        color: var(--primary-blue); 
        display: flex; align-items: center; justify-content: center; 
        font-weight: bold; border-radius: 50%;
    }
    .status-active { background-color: #e8fff3; color: #50cd89; }
    .status-new { background-color: #f1faff; color: #009ef7; }
</style>
@endpush

@section('content')
<div class="container-xxl">
    <div class="card card-flush shadow-sm">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5 border-0">
            <div class="card-title">
                <h2 class="fw-bold"><i class="bi bi-people-fill text-primary me-2"></i>Master Customer</h2>
            </div>
            <div class="card-toolbar">
                <div class="d-flex align-items-center position-relative my-1 me-4">
                    <i class="bi bi-search position-absolute ms-4 text-primary"></i>
                    <input type="text" id="search_customer" class="form-control form-control-solid w-250px ps-12" placeholder="Cari Nama/Email/Kota...">
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_customer">
                    <i class="bi bi-person-plus-fill"></i> Tambah Customer
                </button>
            </div>
        </div>

        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="customer_table">
                    <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="ps-4 w-50px">No</th>
                            <th class="min-w-200px">Customer</th>
                            <th class="min-w-150px">Kontak</th>
                            <th class="min-w-150px">Lokasi</th>
                            <th class="min-w-100px text-center">Total Order</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_add_customer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Customer Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-10">
                <form id="form_customer">
                    <div class="mb-7">
                        <label class="required fw-bold mb-2">Nama Lengkap</label>
                        <input type="text" id="c_name" class="form-control form-control-solid border-blue" placeholder="Contoh: Santo Doni" required>
                    </div>
                    <div class="mb-7">
                        <label class="required fw-bold mb-2">Email</label>
                        <input type="email" id="c_email" class="form-control form-control-solid border-blue" placeholder="santo@example.com" required>
                    </div>
                    <div class="row g-5 mb-7">
                        <div class="col-md-6">
                            <label class="required fw-bold mb-2">No. WhatsApp</label>
                            <input type="text" id="c_phone" class="form-control form-control-solid border-blue" placeholder="0812..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="required fw-bold mb-2">Kota</label>
                            <input type="text" id="c_city" class="form-control form-control-solid border-blue" placeholder="Malang" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="saveCustomer()">Simpan Customer</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Data Dummy Customer
    let initialCustomers = [
        { id: 1, name: 'Santo Doni Romadhoni', email: 'santo@example.com', phone: '08123456789', city: 'Malang', orders: 12, status: 'Active' },
        { id: 2, name: 'Saka Devs', email: 'saka@devs.com', phone: '08571234567', city: 'Jakarta Selatan', orders: 5, status: 'Active' },
        { id: 3, name: 'Ahmad Subarjo', email: 'ahmad@web.id', phone: '08998887776', city: 'Surabaya', orders: 0, status: 'New' }
    ];

    if (!localStorage.getItem('master_customers')) {
        localStorage.setItem('master_customers', JSON.stringify(initialCustomers));
    }

    renderCustomerTable();

    // Search Logic
    document.getElementById('search_customer').addEventListener('keyup', function(e) {
        renderCustomerTable(e.target.value);
    });
});

function renderCustomerTable(filter = "") {
    const tableBody = document.querySelector('#customer_table tbody');
    const customers = JSON.parse(localStorage.getItem('master_customers')) || [];
    
    tableBody.innerHTML = '';

    const filtered = customers.filter(c => 
        c.name.toLowerCase().includes(filter.toLowerCase()) || 
        c.email.toLowerCase().includes(filter.toLowerCase()) ||
        c.city.toLowerCase().includes(filter.toLowerCase())
    );

    filtered.forEach((c, index) => {
        const statusClass = c.status === 'Active' ? 'status-active' : 'status-new';
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="ps-4">${index + 1}</td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="customer-avatar me-3">${c.name.charAt(0)}</div>
                    <div class="d-flex flex-column">
                        <span class="text-gray-800 fw-bold">${c.name}</span>
                        <span class="text-muted fs-7">ID: CUST-${c.id}</span>
                    </div>
                </div>
            </td>
            <td>
                <div class="d-flex flex-column">
                    <span class="text-gray-800">${c.email}</span>
                    <span class="text-muted fs-7">${c.phone}</span>
                </div>
            </td>
            <td><span class="text-gray-700 fw-semibold">${c.city}</span></td>
            <td class="text-center"><span class="badge badge-light-dark fw-bold">${c.orders} Order</span></td>
            <td><span class="badge ${statusClass} fw-bold">${c.status}</span></td>
            <td class="text-end pe-4">
                <button class="btn btn-sm btn-icon btn-light-primary me-2" onclick="showFeatureLocked('Halaman Detail Customer')">
                    <i class="bi bi-eye"></i>
                </button>
                <button class="btn btn-sm btn-icon btn-light-danger" onclick="deleteCustomer(${c.id})">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

function saveCustomer() {
    const name = document.getElementById('c_name').value;
    const email = document.getElementById('c_email').value;
    const phone = document.getElementById('c_phone').value;
    const city = document.getElementById('c_city').value;

    if(!name || !email) return alert('Nama dan Email wajib diisi!');

    let customers = JSON.parse(localStorage.getItem('master_customers')) || [];
    customers.push({
        id: Date.now(),
        name: name,
        email: email,
        phone: phone,
        city: city,
        orders: 0,
        status: 'New'
    });

    localStorage.setItem('master_customers', JSON.stringify(customers));
    bootstrap.Modal.getInstance(document.getElementById('modal_add_customer')).hide();
    document.getElementById('form_customer').reset();
    renderCustomerTable();
}

function deleteCustomer(id) {
    if(confirm('Hapus data customer ini?')) {
        let customers = JSON.parse(localStorage.getItem('master_customers')) || [];
        customers = customers.filter(c => c.id != id);
        localStorage.setItem('master_customers', JSON.stringify(customers));
        renderCustomerTable();
    }
}
</script>
@endpush