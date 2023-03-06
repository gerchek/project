<div class="modal" id="form-modal">
    <div class="form__head">
        <div class="form__closeBtn arrow">
            <div class="arrow__circle"></div>
            <img class="closeBtn__img" src="/images/icons/cross.svg" alt="">
        </div>
        <h1 class="form__title accordion-header accordion-header_active">Связаться с нами</h1>
    </div>
    <div class="form__container">
        <form action="{{ route('feedback.post') }}" method="POST" name="formFeedback" class="contact-form form">
            {{csrf_field()}}
            <input type="hidden" value="{{$page}}" name="page" />
            <input class="contact-form__input" name="phone" type="text" placeholder="Телефон*">
            <input class="contact-form__input" name="name" type="text" placeholder="Имя">
            <textarea class="contact-form__input contact-form__area" name="msg" placeholder="Текст сообщения"></textarea>
            <span class="contact-form__policy">Нажимая "Отправить" вы соглашаетесь с политикой обработки персональных данных</span>
            <input class="contact-form__btn btn" type="submit" value="Отправить">
{{--            <input type="hidden" id="g-recaptcha-response-feedback" name="recaptcha_response" value="">--}}
        </form>
    </div>
</div>

@push('scripts')
{{--    <script src="https://www.google.com/recaptcha/api.js?onload=recaptchaFeedbackFormCallback&render={{env('RECAPTCHA_KEY')}}"></script>--}}
{{--    <script type="text/javascript">--}}
{{--        var recaptchaFeedbackFormCallback = function() {--}}
{{--            grecaptcha.ready(function() {--}}
{{--                grecaptcha.execute('{{env('RECAPTCHA_KEY')}}').then(function(token) {--}}
{{--                    var recaptchaInputs = document.querySelectorAll('#g-recaptcha-response-feedback');--}}
{{--                    recaptchaInputs.forEach(function (element) {--}}
{{--                        element.value = token;--}}
{{--                    });--}}
{{--                });--}}
{{--            });--}}
{{--        };--}}
{{--    </script>--}}
@endpush
