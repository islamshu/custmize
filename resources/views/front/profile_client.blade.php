@extends('layouts.client')
@section('content_client')
    
<h2>معلومات الحساب</h2>

<form id="updateProfileForm" class="profile-form">
    @csrf
    <div class="form-group">
        <div class="input-group">
            <label for="email">البريد الإلكتروني</label>
            <input type="email" name="email" id="email" value="{{ auth('client')->user()->email }}" readonly>
        </div>
        <div class="input-group">
            <label for="first_name">الاسم الأول</label>
            <input type="text" name="first_name" id="first_name" value="{{ auth('client')->user()->first_name }}">
        </div>
    </div>

    <div class="form-group">
        <div class="input-group">
            <label for="last_name">اسم العائلة</label>
            <input type="text" name="last_name" id="last_name" value="{{ auth('client')->user()->last_name }}">
        </div>
        <div class="input-group">
            <label for="phone">رقم الهاتف</label>
            <input type="tel" name="phone" id="phone" value="{{ auth('client')->user()->phone }}" placeholder="أضف الرقم">
        </div>
    </div>

    <div class="form-group">
        <div class="input-group">
            <label for="birthdate">تاريخ الميلاد</label>
            <input type="date" name="birthdate" id="birthdate" placeholder="dd/mm/yyyy" value="{{ auth('client')->user()->DOB }}">
        </div>
        <div class="input-group">
            <label>الجنس</label>
            <div class="gender-options">
                <div class="gender-option">
                    <input type="radio" id="male" name="gender" value="1" {{ auth('client')->user()->gender == '1' ? 'checked' : '' }}>
                    <label for="male">ذكر</label>
                </div>
                <div class="gender-option">
                    <input type="radio" id="female" name="gender" value="2" {{ auth('client')->user()->gender == '2' ? 'checked' : '' }}>
                    <label for="female">أنثى</label>
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="save-button">حفظ التعديلات</button>
</form>
@endsection