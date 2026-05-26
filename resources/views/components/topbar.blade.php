<header class="topbar">
    <div style="display:flex;align-items:center;gap:1rem;">
        <button class="topbar-icon" id="sidebar-toggle" style="display:none;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
        </button>
        <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
    </div>

    <div class="topbar-actions">
        {{-- Search --}}
        <div class="topbar-search" id="topbar-search-wrap" style="position:relative;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:16px;height:16px;color:rgba(148,163,184,0.6);flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
            <input type="text" placeholder="Cari siswa, karya..." id="topbar-search-input" autocomplete="off">
            <div class="topbar-search-shortcut">⌘K</div>
            
            {{-- Autocomplete Dropdown Panel --}}
            <div class="search-results-panel" id="search-results-panel"></div>
        </div>

        {{-- Notification --}}
        <div class="dropdown" id="notification-dropdown">
            <button class="topbar-icon" data-dropdown id="notification-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                <span class="notification-dot" id="notif-dot" style="display:none;"></span>
            </button>
            <div class="dropdown-menu notification-panel">
                <div class="notif-header">
                    <span style="font-weight:600;font-size:0.9375rem;color:#f1f5f9;">Notifikasi</span>
                    <button class="notif-mark-read" id="mark-all-read">Tandai Dibaca</button>
                </div>
                <div class="notif-list" id="notif-list">
                    <div style="padding: 2rem 1rem; text-align: center; color: var(--text-muted);">
                        Memuat notifikasi...
                    </div>
                </div>
                <div class="notif-footer">
                    <a href="#" id="view-all-notif-btn">Lihat Semua Notifikasi</a>
                </div>
            </div>
        </div>

        {{-- Profile --}}
        <div class="dropdown">
            <div class="avatar" data-dropdown style="cursor:pointer;background:rgba(99,102,241,0.2);color:#818cf8;border:2px solid rgba(99,102,241,0.3);">
                <span>{{ substr(auth()->user()->name, 0, 2) }}</span>
            </div>
            <div class="dropdown-menu">
                <div style="padding:0.625rem 0.875rem;border-bottom:1px solid rgba(255,255,255,0.06);margin-bottom:0.375rem;">
                    <div style="font-weight:600;color:#fff;font-size:0.875rem;">{{ auth()->user()->name }}</div>
                    <div style="font-size:0.75rem;color:rgba(255,255,255,0.4);">{{ auth()->user()->email }}</div>
                </div>
                <a href="{{ route('home') }}" class="dropdown-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                    Halaman Utama
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="dropdown-item danger">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

{{-- Blur Overlay Notification Modal --}}
<div class="notif-modal-overlay" id="notif-modal">
    <div class="notif-modal-card">
        <div class="notif-modal-header">
            <h2 class="notif-modal-title">Semua Aktivitas & Notifikasi</h2>
            <button class="notif-modal-close" id="close-notif-modal">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:20px;height:20px;"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="notif-modal-body">
            <div id="modal-notif-list-container">
                <!-- Loaded via AJAX -->
            </div>
        </div>
    </div>
</div>

<style>
/* Search autocomplete panel */
.search-results-panel {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    right: 0;
    background: rgba(15, 23, 42, 0.95);
    border: 1px solid rgba(148, 163, 184, 0.12);
    border-radius: var(--radius-md, 0.75rem);
    padding: 0.5rem;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.7);
    z-index: 999;
    display: none;
    max-height: 400px;
    overflow-y: auto;
}
.search-results-panel.show {
    display: block !important;
}
.search-section-title {
    font-size: 0.6875rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #818cf8;
    margin: 0.5rem 0.5rem 0.25rem;
    padding-bottom: 0.25rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}
.search-result-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 0.75rem;
    border-radius: var(--radius-sm, 0.375rem);
    color: #cbd5e1;
    text-decoration: none;
    transition: all 0.2s ease;
    font-size: 0.8125rem;
}
.search-result-item:hover {
    background: rgba(99, 102, 241, 0.12);
    color: #fff;
}
.search-result-meta {
    font-size: 0.6875rem;
    color: #64748b;
}

/* Modal Overlay styling */
.notif-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(8, 10, 18, 0.65);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}
.notif-modal-overlay.open {
    opacity: 1;
    pointer-events: auto;
}
.notif-modal-card {
    background: rgba(15, 23, 42, 0.9);
    border: 1px solid rgba(148, 163, 184, 0.12);
    border-radius: 1rem;
    width: 90%;
    max-width: 680px;
    max-height: 80vh;
    box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(255, 255, 255, 0.05);
    transform: scale(0.95);
    transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
}
.notif-modal-overlay.open .notif-modal-card {
    transform: scale(1);
}
.notif-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(148, 163, 184, 0.08);
}
.notif-modal-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #f8fafc;
    margin: 0;
}
.notif-modal-close {
    background: none;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    padding: 0.375rem;
    border-radius: var(--radius-sm, 0.375rem);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}
.notif-modal-close:hover {
    background: rgba(255, 255, 255, 0.06);
    color: #f8fafc;
}
.notif-modal-body {
    padding: 1.5rem;
    overflow-y: auto;
    flex: 1;
}

/* Modal notifications styling */
.modal-notif-row {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    background: rgba(30, 41, 59, 0.3);
    border: 1px solid rgba(148, 163, 184, 0.06);
    border-radius: 0.75rem;
    margin-bottom: 0.75rem;
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
}
.modal-notif-row:hover {
    background: rgba(99, 102, 241, 0.06);
    border-color: rgba(99, 102, 241, 0.2);
    transform: translateY(-2px);
}
.modal-notif-row.unread {
    background: rgba(99, 102, 241, 0.04);
    border-color: rgba(99, 102, 241, 0.15);
}
.modal-notif-row.unread::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #ef4444;
    position: absolute;
    right: 1.25rem;
    top: 1.25rem;
}
.modal-notif-row {
    position: relative;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const notifDot = document.getElementById('notif-dot');
    const notifList = document.getElementById('notif-list');
    const markReadBtn = document.getElementById('mark-all-read');
    
    let allNotifications = [];

    // Load Notifications dynamically
    function loadNotifications() {
        fetch('{{ route('admin.notifications.api') }}')
            .then(res => res.json())
            .then(data => {
                allNotifications = data.notifications;
                
                // Show/hide red indicator dot
                if (data.unread_count > 0) {
                    notifDot.style.display = 'block';
                } else {
                    notifDot.style.display = 'none';
                }

                // Render in dropdown panel
                if (data.notifications.length === 0) {
                    notifList.innerHTML = `
                        <div style="padding: 2.5rem 1rem; text-align: center; color: #64748b; font-size: 0.8125rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 28px; height: 28px; margin: 0 auto 0.5rem; opacity: 0.5;"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                            Tidak ada aktivitas terbaru.
                        </div>
                    `;
                    return;
                }

                let html = '';
                // Only display top 5 in dropdown list
                data.notifications.slice(0, 5).forEach(item => {
                    let iconBg = 'rgba(59,130,246,0.15)';
                    let iconColor = '#60a5fa';
                    let svgIcon = '';

                    if (item.type === 'portfolio') {
                        svgIcon = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>`;
                    } else if (item.type === 'student') {
                        iconBg = 'rgba(16,185,129,0.15)';
                        iconColor = '#34d399';
                        svgIcon = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>`;
                    } else {
                        iconBg = 'rgba(139,92,246,0.15)';
                        iconColor = '#a78bfa';
                        svgIcon = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>`;
                    }

                    html += `
                        <a href="${item.url}" class="notif-item ${item.unread ? 'unread' : ''}">
                            <div class="notif-icon" style="background:${iconBg};color:${iconColor};">
                                ${svgIcon}
                            </div>
                            <div class="notif-body">
                                <p>${item.body}</p>
                                <span class="notif-time" style="display:inline-flex;align-items:center;gap:0.25rem;"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:12px;height:12px;opacity:0.7;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>${item.time}</span>
                            </div>
                        </a>
                    `;
                });
                notifList.innerHTML = html;
            });
    }

    // Call once immediately
    loadNotifications();

    // Poll every 30 seconds for new activities
    setInterval(loadNotifications, 30000);

    // Mark all as read
    markReadBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        fetch('{{ route('admin.notifications.markRead') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                notifDot.style.display = 'none';
                loadNotifications();
            }
        });
    });

    // ===== VIEW ALL NOTIFICATIONS MODAL OVERLAY =====
    const viewAllBtn = document.getElementById('view-all-notif-btn');
    const notifModal = document.getElementById('notif-modal');
    const closeNotifModal = document.getElementById('close-notif-modal');
    const modalListContainer = document.getElementById('modal-notif-list-container');

    viewAllBtn.addEventListener('click', function (e) {
        e.preventDefault();
        notifModal.classList.add('open');

        // Populate Modal List
        if (allNotifications.length === 0) {
            modalListContainer.innerHTML = `
                <div style="padding: 4rem 1rem; text-align: center; color: #64748b;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" style="width: 48px; height: 48px; margin: 0 auto 1rem; opacity: 0.4;"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                    <p style="font-size: 1rem; font-weight: 500;">Tidak ada aktivitas terbaru yang terdeteksi.</p>
                </div>
            `;
            return;
        }

        let html = '';
        allNotifications.forEach(item => {
            let iconBg = 'rgba(59,130,246,0.15)';
            let iconColor = '#60a5fa';
            let svgIcon = '';
            let labelBadge = '';

            if (item.type === 'portfolio') {
                labelBadge = '<span class="badge badge-primary" style="font-size:0.6875rem;">Karya Baru</span>';
                svgIcon = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>`;
            } else if (item.type === 'student') {
                iconBg = 'rgba(16,185,129,0.15)';
                iconColor = '#34d399';
                labelBadge = '<span class="badge badge-success" style="font-size:0.6875rem;">Siswa Baru</span>';
                svgIcon = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>`;
            } else {
                iconBg = 'rgba(139,92,246,0.15)';
                iconColor = '#a78bfa';
                labelBadge = '<span class="badge badge-info" style="font-size:0.6875rem;">Pesan / Feedback</span>';
                svgIcon = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>`;
            }

            html += `
                <a href="${item.url}" class="modal-notif-row ${item.unread ? 'unread' : ''}">
                    <div class="notif-icon" style="background:${iconBg};color:${iconColor};width:42px;height:42px;">
                        ${svgIcon}
                    </div>
                    <div style="flex:1;">
                        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
                            <span style="font-weight:600;font-size:0.9375rem;color:#f8fafc;">${item.title}</span>
                            ${labelBadge}
                        </div>
                        <p style="font-size:0.875rem;color:#cbd5e1;margin:0 0 0.375rem;line-height:1.4;">${item.body}</p>
                        <span style="display:inline-flex;align-items:center;gap:0.25rem;font-size:0.75rem;color:#64748b;"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>${item.time}</span>
                    </div>
                </a>
            `;
        });
        modalListContainer.innerHTML = html;
    });

    // Close Modal
    function closeModal() {
        notifModal.classList.remove('open');
    }

    closeNotifModal.addEventListener('click', closeModal);
    notifModal.addEventListener('click', function (e) {
        if (e.target === notifModal) closeModal();
    });

    // ===== navbar autOCOMPLETE REAL-TIME SEARCH =====
    const searchInput = document.getElementById('topbar-search-input');
    const resultsPanel = document.getElementById('search-results-panel');

    let debounceTimer;

    searchInput.addEventListener('input', function () {
        const query = this.value.trim();

        clearTimeout(debounceTimer);

        if (query.length < 2) {
            resultsPanel.classList.remove('show');
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`{{ route('admin.search.api') }}?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    let html = '';
                    let hasResults = false;

                    // 1. Siswa Results
                    if (data.students && data.students.length > 0) {
                        hasResults = true;
                        html += `<div class="search-section-title">Siswa</div>`;
                        data.students.forEach(student => {
                            let details = [student.class, student.major].filter(Boolean).join(' · ');
                            html += `
                                <a href="${student.url}" class="search-result-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px;color:#34d399;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                    <div style="flex:1;">
                                        <div style="font-weight:600;">${student.name}</div>
                                        <div class="search-result-meta">${details || student.email}</div>
                                    </div>
                                </a>
                            `;
                        });
                    }

                    // 2. Karya Results
                    if (data.portfolios && data.portfolios.length > 0) {
                        hasResults = true;
                        html += `<div class="search-section-title">Karya / Portofolio</div>`;
                        data.portfolios.forEach(work => {
                            html += `
                                <a href="${work.url}" class="search-result-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px;height:16px;color:#60a5fa;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                    <div style="flex:1;">
                                        <div style="font-weight:600;">${work.title}</div>
                                        <div class="search-result-meta">Oleh ${work.student_name}</div>
                                    </div>
                                </a>
                            `;
                        });
                    }

                    if (!hasResults) {
                        html = `
                            <div style="padding:1.5rem 1rem;text-align:center;color:#64748b;font-size:0.8125rem;">
                                Tidak ada siswa atau karya yang cocok.
                            </div>
                        `;
                    }

                    resultsPanel.innerHTML = html;
                    resultsPanel.classList.add('show');
                });
        }, 200);
    });

    // Close search panel on click outside
    document.addEventListener('click', function (e) {
        if (!searchInput.contains(e.target) && !resultsPanel.contains(e.target)) {
            resultsPanel.classList.remove('show');
        }
    });

    // Keyboard shortcut Ctrl+K / Cmd+K to focus search input
    document.addEventListener('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
            e.preventDefault();
            searchInput.focus();
        }
    });
});
</script>
