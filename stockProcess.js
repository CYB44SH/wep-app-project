document.addEventListener("DOMContentLoaded", () => {
    const forms = document.querySelectorAll('.add-to-cart-form');

    forms.forEach(form => {
        form.addEventListener('submit', function(e){
            e.preventDefault(); // منع إعادة تحميل الصفحة

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message); // رسالة نجاح أو نفاد المنتج
            })
          
          
        });
    });
});
