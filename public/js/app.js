document.addEventListener('DOMContentLoaded', function () {
    var toggleBtn = document.getElementById('sidebar-toggle');
    var sidebar = document.getElementById('sidebar');
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function() { sidebar.classList.toggle('open'); });
    }
    document.querySelectorAll('[data-dropdown]').forEach(function(btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var menu = this.nextElementSibling;
            document.querySelectorAll('.dropdown-menu.show').forEach(function(m) {
                if (m !== menu) m.classList.remove('show');
            });
            menu.classList.toggle('show');
        });
    });
    document.addEventListener('click', function() {
        document.querySelectorAll('.dropdown-menu.show').forEach(function(m) { m.classList.remove('show'); });
    });
    var fileInput = document.getElementById('file-upload');
    var filePreview = document.getElementById('file-preview');
    if (fileInput && filePreview) {
        fileInput.addEventListener('change', function () {
            var file = this.files[0];
            if (file && file.type.startsWith('image/')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    filePreview.innerHTML = '<img src="' + e.target.result + '" style="max-height:200px;border-radius:var(--radius);">';
                };
                reader.readAsDataURL(file);
            } else if (file) {
                filePreview.innerHTML = '<p class="text-sm">' + file.name + '</p>';
            }
        });
    }

    // ===== Smooth scrolling for anchor links =====
    function smoothScrollTo(hash) {
        // Special case: #home scrolls to the very top
        if (hash === '#home') {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return true;
        }

        var target = document.querySelector(hash);
        if (target) {
            var navbarHeight = document.querySelector('.navbar') ? document.querySelector('.navbar').offsetHeight : 0;
            var targetPosition = target.getBoundingClientRect().top + window.pageYOffset - navbarHeight;
            window.scrollTo({ top: targetPosition, behavior: 'smooth' });
            return true;
        }
        return false;
    }

    // Helper: extract pathname from any href (handles full URLs and relative paths)
    function getPathFromHref(href) {
        try {
            var url = new URL(href, window.location.origin);
            return url.pathname;
        } catch (e) {
            return href;
        }
    }

    // Handle click on anchor links
    document.querySelectorAll('a[href*="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function (e) {
            var href = this.getAttribute('href');
            var hashIndex = href.indexOf('#');
            if (hashIndex === -1) return;

            var hash = href.substring(hashIndex);
            var pathBeforeHash = href.substring(0, hashIndex);

            // Resolve the path from the href to handle full URLs like http://127.0.0.1:8000#featured
            var resolvedPath = getPathFromHref(pathBeforeHash || window.location.pathname);
            var currentPath = window.location.pathname;

            // Normalize: remove trailing slash for comparison
            var normResolved = resolvedPath.replace(/\/+$/, '') || '/';
            var normCurrent = currentPath.replace(/\/+$/, '') || '/';

            var isSamePage = normResolved === normCurrent;

            if (isSamePage) {
                e.preventDefault();
                smoothScrollTo(hash);
                // Update URL hash without jumping
                history.pushState(null, null, hash);
            }
            // If not same page, let the browser navigate normally (the hash will trigger on load)
        });
    });

    // On page load: if URL has a hash, smooth-scroll to it
    if (window.location.hash) {
        // Small delay to ensure DOM is fully rendered and images are loaded
        setTimeout(function() {
            smoothScrollTo(window.location.hash);
        }, 150);
    }

    // ===== Scroll-spy: highlight active navbar link =====
    var scrollLinks = document.querySelectorAll('.nav-scroll-link');
    if (scrollLinks.length > 0) {
        var sectionIds = [];
        scrollLinks.forEach(function(link) {
            var sec = link.getAttribute('data-section');
            if (sec) sectionIds.push(sec);
        });

        function updateActiveNavLink() {
            var navbarHeight = 80;
            var scrollPos = window.scrollY + navbarHeight + 10;
            var currentSection = '';

            for (var i = sectionIds.length - 1; i >= 0; i--) {
                var el = document.getElementById(sectionIds[i]);
                if (el && el.getBoundingClientRect().top + window.pageYOffset <= scrollPos) {
                    currentSection = sectionIds[i];
                    break;
                }
            }

            // If near top of page, highlight "home"
            if (window.scrollY < 100) {
                currentSection = 'home';
            }

            scrollLinks.forEach(function(link) {
                if (link.getAttribute('data-section') === currentSection) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        }

        window.addEventListener('scroll', updateActiveNavLink, { passive: true });
        updateActiveNavLink(); // initial check
    }

    // ===== Topbar Search Functionality =====
    var searchInput = document.getElementById('topbar-search-input');
    if (searchInput) {
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                var query = this.value.trim();
                if (query.length > 0) {
                    // Redirect to students search or works search
                    window.location.href = '/admin/students?search=' + encodeURIComponent(query);
                }
            }
        });

        // Keyboard shortcut: Ctrl+K or Cmd+K to focus search
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
            }
        });
    }

    // ===== Notification Mark All Read =====
    var markReadBtn = document.getElementById('mark-all-read');
    if (markReadBtn) {
        markReadBtn.addEventListener('click', function() {
            document.querySelectorAll('.notif-item.unread').forEach(function(item) {
                item.classList.remove('unread');
            });
            var dot = document.getElementById('notif-dot');
            if (dot) dot.style.display = 'none';
        });
    }
});
