<script src="{{asset('assets-dashboard')}}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('assets-dashboard')}}/libs/simplebar/simplebar.min.js"></script>

<script src="{{asset('assets-dashboard')}}/libs/apexcharts/apexcharts.min.js"></script>
<script src="{{asset('assets-dashboard')}}/data/stock-prices.js"></script>
<script src="{{asset('assets-dashboard')}}/libs/jsvectormap/js/jsvectormap.min.js"></script>
<script src="{{asset('assets-dashboard')}}/libs/jsvectormap/maps/world.js"></script>
<script src="{{asset('assets-dashboard')}}/js/pages/index.init.js"></script>
<script src="{{asset('assets-dashboard')}}/js/app.js"></script>

{{-- Dark Mode Persistence Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const htmlElement = document.documentElement;
    
    // تحديث أيقونة الـ dark mode
    function updateDarkModeIcon(theme) {
        const darkModeBtn = document.getElementById('light-dark-mode');
        if (darkModeBtn) {
            const moonIcon = darkModeBtn.querySelector('.dark-mode');
            const sunIcon = darkModeBtn.querySelector('.light-mode');
            
            if (theme === 'dark') {
                if (moonIcon) moonIcon.style.display = 'none';
                if (sunIcon) sunIcon.style.display = 'inline-block';
            } else {
                if (moonIcon) moonIcon.style.display = 'inline-block';
                if (sunIcon) sunIcon.style.display = 'none';
            }
        }
    }
    
    // تحديث الأيقونة بناءً على الثيم الحالي
    const currentTheme = htmlElement.getAttribute('data-bs-theme') || 'light';
    updateDarkModeIcon(currentTheme);
    
    // تعديل الـ event listener الأصلي للـ dark mode
    setTimeout(function() {
        const darkModeToggle = document.getElementById('light-dark-mode');
        if (darkModeToggle) {
            // إزالة الـ event listeners الموجودة
            const newToggle = darkModeToggle.cloneNode(true);
            darkModeToggle.parentNode.replaceChild(newToggle, darkModeToggle);
            
            // إضافة event listener جديد
            newToggle.addEventListener('click', function(e) {
                e.preventDefault();
                
                const currentTheme = htmlElement.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                
                // تطبيق الثيم الجديد
                htmlElement.setAttribute('data-bs-theme', newTheme);
                htmlElement.setAttribute('data-startbar', newTheme);
                
                // حفظ الثيم في localStorage
                localStorage.setItem('theme', newTheme);
                
                // تحديث الأيقونة
                updateDarkModeIcon(newTheme);
            });
        }
    }, 100); // تقليل الوقت من 500 إلى 100
});
</script>

@stack('scripts')