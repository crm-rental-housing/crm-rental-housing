@component('mail::message')
Вы получили это письмо, т. к. зарегистрировались на сайте, если это были не Вы, проигнорируйте это сообщение
Подтвердите электронную почту, перейдя по следующей ссылке
@component('mail::button', ['url' => $verification_url])
Подтвердить Email
@endcomponent
@endcomponent
