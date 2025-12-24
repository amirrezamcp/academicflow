document.addEventListener('DOMContentLoaded', function () {
    // انیمیشن ورود صفحه
    const page = document.querySelector('.page-animate');
    if (page) {
        setTimeout(() => {
            page.style.opacity = '1';
            page.style.transform = 'translateY(0) scale(1)';
        }, 50);
    }

    // مدیریت آلرت‌ها
    const alerts = document.querySelectorAll('.alert-message');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 400);
        }, 4000);

        // بستن آلرت با کلیک روی دکمه
        const closeBtn = alert.querySelector('button');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 400);
            });
        }
    });

    // افزودن افکت hover به کارت‌ها
    document.querySelectorAll('.card-modern').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
        });

        card.addEventListener('mouseleave', function() {
            this.style.zIndex = '1';
        });
    });

    // مدیریت فیلدهای فرم
    document.querySelectorAll('.input-modern').forEach(input => {
        // افکت focus
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-primary-200');
        });

        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-primary-200');
        });
    });

    // نمایش تاریخ و زمان به صورت real-time
    function updateDateTime() {
        const now = new Date();
        const options = {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        };
        const formatter = new Intl.DateTimeFormat('fa-IR', options);
        const dateElements = document.querySelectorAll('.live-date');
        dateElements.forEach(el => {
            el.textContent = formatter.format(now);
        });
    }

    // اگر المان با کلاس live-date وجود دارد
    if (document.querySelector('.live-date')) {
        updateDateTime();
        setInterval(updateDateTime, 60000); // آپدیت هر دقیقه
    }

    // افزودن confirm delete با SweetAlert2 (اگر بخواهی زیباتر بشه)
    window.confirmDelete = function (form, message = 'آیا از حذف این مورد مطمئن هستید؟') {
        if (confirm(message)) {
            // اضافه کردن انیمیشن قبل از ارسال
            const button = form.querySelector('button[type="submit"]');
            if (button) {
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> در حال حذف...';
                button.disabled = true;
            }

            setTimeout(() => {
                form.submit();
            }, 500);
        }
    };

    // افزودن قابلیت copy به clipboard
    window.copyToClipboard = function(text, element = null) {
        navigator.clipboard.writeText(text).then(() => {
            if (element) {
                const original = element.innerHTML;
                element.innerHTML = '<i class="fas fa-check mr-2"></i> کپی شد!';
                element.classList.add('bg-green-100', 'text-green-800');

                setTimeout(() => {
                    element.innerHTML = original;
                    element.classList.remove('bg-green-100', 'text-green-800');
                }, 2000);
            } else {
                alert('متن کپی شد: ' + text);
            }
        });
    };
});

// تابع برای نمایش modal ساده
window.showModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
};

window.hideModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }
};

// Keyboard shortcuts (اختیاری)
document.addEventListener('keydown', function(e) {
    // Ctrl + K برای جستجو
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.querySelector('input[type="search"]');
        if (searchInput) searchInput.focus();
    }

    // Escape برای بستن modal
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal').forEach(modal => {
            if (!modal.classList.contains('hidden')) {
                window.hideModal(modal.id);
            }
        });
    }
});
