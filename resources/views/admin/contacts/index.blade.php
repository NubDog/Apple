@extends('layouts.admin')

@section('title', 'Quản lý liên hệ')

@section('content')
<div class="contacts-container">
    <div class="card">
        <div class="card-title">
            Quản lý tin nhắn liên hệ
            <div class="actions">
                <a href="{{ route('admin.contacts.index', ['status' => 'all']) }}" class="btn {{ $status == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi bi-list"></i> Tất cả
                </a>
                <a href="{{ route('admin.contacts.index', ['status' => 'not_replied']) }}" class="btn {{ $status == 'not_replied' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi bi-clock"></i> Chưa phản hồi
                </a>
                <a href="{{ route('admin.contacts.index', ['status' => 'replied']) }}" class="btn {{ $status == 'replied' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi bi-check-circle"></i> Đã phản hồi
                </a>
            </div>
        </div>
        
        <div class="filters-container">
            <div class="row">
                <div class="col-md-4">
                    <div class="search-container">
                        <input type="text" id="search-contacts" class="search-input" placeholder="Tìm kiếm liên hệ...">
                        <i class="bi bi-search search-icon"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="contacts-stats">
            <div class="stat-item">
                <div class="stat-value">{{ App\Models\Contact::count() }}</div>
                <div class="stat-label">Tổng số liên hệ</div>
            </div>
            <div class="stat-item new-contacts">
                <div class="stat-value">{{ App\Models\Contact::where('status', false)->count() }}</div>
                <div class="stat-label">Chưa phản hồi</div>
            </div>
            <div class="stat-item replied-contacts">
                <div class="stat-value">{{ App\Models\Contact::where('status', true)->count() }}</div>
                <div class="stat-label">Đã phản hồi</div>
            </div>
        </div>
        
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        
        <div class="table-responsive">
            <table class="table contacts-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Người gửi</th>
                        <th>Chủ đề</th>
                        <th>Ngày nhận</th>
                        <th>Trạng thái</th>
                        <th width="150">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                    <tr>
                        <td>
                            <div class="contact-id">#{{ $contact->id }}</div>
                        </td>
                        <td>
                            <div class="contact-name">{{ $contact->name }}</div>
                            <div class="contact-email">{{ $contact->email }}</div>
                        </td>
                        <td>
                            <div class="contact-subject">{{ Str::limit($contact->subject ?: 'Không có chủ đề', 50) }}</div>
                        </td>
                        <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="status-badge {{ $contact->status ? 'replied' : 'not-replied' }}">
                                {{ $contact->status ? 'Đã phản hồi' : 'Chưa phản hồi' }}
                            </div>
                        </td>
                        <td>
                            <div class="actions-container">
                                <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn-action view" title="Xem chi tiết">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.contacts.reply', $contact->id) }}" class="btn-action reply" title="Phản hồi">
                                    <i class="bi bi-reply"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.contacts.update-status', $contact->id) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $contact->status ? '0' : '1' }}">
                                    <button type="submit" class="btn-action status" title="{{ $contact->status ? 'Đánh dấu chưa phản hồi' : 'Đánh dấu đã phản hồi' }}">
                                        <i class="bi {{ $contact->status ? 'bi-x-circle' : 'bi-check-circle' }}"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.contacts.destroy', $contact->id) }}" class="d-inline delete-form" data-contact-id="{{ $contact->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-action delete" title="Xóa" onclick="confirmDelete({{ $contact->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Không có tin nhắn liên hệ nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="pagination-container">
            {{ $contacts->links() }}
        </div>
    </div>
</div>

@push('styles')
<style>
    .contacts-container {
        width: 100%;
    }
    
    .actions {
        display: flex;
        gap: 10px;
    }
    
    .filters-container {
        margin: 20px 0;
    }
    
    .search-container {
        position: relative;
    }
    
    .search-input {
        width: 100%;
        padding: 10px 15px;
        border-radius: 5px;
        border: 1px solid #ddd;
        padding-left: 40px;
    }
    
    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
    }
    
    .filters-right {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }
    
    .filter-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .filter-select {
        padding: 8px 30px 8px 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
        background-color: white;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 1em;
    }
    
    .contacts-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .stat-item {
        background-color: #f8f9fa;
        border-radius: 5px;
        padding: 15px;
        text-align: center;
    }
    
    .stat-value {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .stat-label {
        color: #666;
        font-size: 14px;
    }
    
    .new-contacts {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .replied-contacts {
        background-color: #d4edda;
        color: #155724;
    }
    
    .contacts-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .contacts-table th {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        padding: 12px 15px;
        text-align: left;
    }
    
    .contacts-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #dee2e6;
        vertical-align: middle;
    }
    
    .contact-name {
        font-weight: 500;
    }
    
    .contact-email {
        font-size: 13px;
        color: #666;
    }
    
    .contact-subject {
        max-width: 250px;
    }
    
    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-badge.replied {
        background-color: #d4edda;
        color: #155724;
    }
    
    .status-badge.not-replied {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .actions-container {
        display: flex;
        gap: 5px;
    }
    
    .btn-action {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: white;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    
    .btn-action.view {
        background-color: #17a2b8;
    }
    
    .btn-action.reply {
        background-color: #28a745;
    }
    
    .btn-action.status {
        background-color: #6c757d;
    }
    
    .btn-action.delete {
        background-color: #dc3545;
    }
    
    .pagination-container {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }
    
    @media (max-width: 768px) {
        .contacts-stats {
            grid-template-columns: 1fr;
        }
        
        .filters-right {
            margin-top: 15px;
            justify-content: flex-start;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('search-contacts');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('.contacts-table tbody tr');
                
                rows.forEach(row => {
                    const name = row.querySelector('.contact-name').textContent.toLowerCase();
                    const email = row.querySelector('.contact-email').textContent.toLowerCase();
                    const subject = row.querySelector('.contact-subject').textContent.toLowerCase();
                    
                    if (name.includes(searchTerm) || email.includes(searchTerm) || subject.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
        
        // Delete confirmation
        window.confirmDelete = function(id) {
            if (confirm('Bạn có chắc chắn muốn xóa liên hệ này?')) {
                document.querySelector(`.delete-form[data-contact-id="${id}"]`).submit();
            }
        };
    });
</script>
@endpush
@endsection 