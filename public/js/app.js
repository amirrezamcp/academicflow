document.addEventListener('DOMContentLoaded', function () {

    const page = document.querySelector('.page-animate');
    if (page) page.style.opacity = '1';

    const alert = document.querySelector('.alert-message');
    if (alert) {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-8px)';
            setTimeout(() => alert.remove(), 400);
        }, 2800);
    }
});

window.confirmDelete = function (form) {
    if (confirm('آیا از حذف مطمئن هستید؟')) {
        form.submit();
    }
};
