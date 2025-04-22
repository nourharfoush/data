document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    const currentStageSelect = document.getElementById('currentStage');
    const specializedFields = document.getElementById('specializedFields');

    // إظهار/إخفاء حقول المرحلة التخصصية
    currentStageSelect.addEventListener('change', function() {
        if (this.value === 'specialized') {
            specializedFields.style.display = 'block';
            specializedFields.querySelector('input').required = true;
        } else {
            specializedFields.style.display = 'none';
            specializedFields.querySelector('input').required = false;
        }
    });

    // التحقق من صحة البيانات قبل الإرسال
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // التحقق من الرقم القومي
        const nationalId = form.querySelector('[name="national_id"]').value;
        if (nationalId.length !== 14 && !/^[A-Z]\d+$/.test(nationalId)) {
            alert('الرجاء إدخال رقم قومي صحيح (14 رقم) أو رقم جواز سفر صحيح');
            return;
        }

        // التحقق من رقم الهاتف
        const phone = form.querySelector('[name="phone_number"]').value;
        if (!/^01[0125][0-9]{8}$/.test(phone)) {
            alert('الرجاء إدخال رقم هاتف صحيح');
            return;
        }

        // التحقق من السن
        const age = parseInt(form.querySelector('[name="age"]').value);
        if (age < 18 || age > 100) {
            alert('الرجاء إدخال سن صحيح (18-100)');
            return;
        }

        // التحقق من حجم الملفات
        const files = form.querySelectorAll('input[type="file"]');
        for (let file of files) {
            if (file.files[0] && file.files[0].size > 5 * 1024 * 1024) {
                alert('حجم الملف ' + file.name + ' يجب أن يكون أقل من 5 ميجابايت');
                return;
            }
        }

        // إرسال النموذج
        form.submit();
    });

    // تنسيق حقل رقم الهاتف أثناء الكتابة
    const phoneInput = form.querySelector('[name="phone_number"]');
    phoneInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 11) {
            this.value = this.value.slice(0, 11);
        }
    });

    // تنسيق حقل الرقم القومي أثناء الكتابة
    const nationalIdInput = form.querySelector('[name="national_id"]');
    nationalIdInput.addEventListener('input', function() {
        if (!/^[A-Z]/.test(this.value)) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 14) {
                this.value = this.value.slice(0, 14);
            }
        }
    });
}); 