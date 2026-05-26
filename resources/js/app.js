document.addEventListener('DOMContentLoaded', function () {
    // Sidebar toggle for mobile
    const toggleBtn = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', () => sidebar.classList.toggle('open'));
    }

    // Dropdown menus
    document.querySelectorAll('[data-dropdown]').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const menu = this.nextElementSibling;
            document.querySelectorAll('.dropdown-menu.show').forEach(m => {
                if (m !== menu) m.classList.remove('show');
            });
            menu.classList.toggle('show');
        });
    });
    document.addEventListener('click', () => {
        document.querySelectorAll('.dropdown-menu.show').forEach(m => m.classList.remove('show'));
    });

    // File upload preview
    const fileInput = document.getElementById('file-upload');
    const filePreview = document.getElementById('file-preview');
    if (fileInput && filePreview) {
        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = e => {
                    filePreview.innerHTML = `<img src="${e.target.result}" style="max-height:200px;border-radius:var(--radius);">`;
                };
                reader.readAsDataURL(file);
            } else if (file) {
                filePreview.innerHTML = `<p class="text-sm">${file.name}</p>`;
            }
        });
    }

    // Tab switching
    document.querySelectorAll('[data-tab]').forEach(tab => {
        tab.addEventListener('click', function () {
            const target = this.dataset.tab;
            this.closest('.tabs').querySelectorAll('[data-tab]').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
            document.getElementById(target)?.classList.add('active');
        });
    });
});
