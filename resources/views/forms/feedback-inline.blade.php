<section class="contact section">
    <div class="container">
        <div class="contact__inner">
            <div class="contact__side">
                <div class="contact__logo">
                    <img class="contact__logo-img" src="/images/logo/logo.svg" alt="">
                </div>
                <div class="contact__head head">
                    <h1 class="contact__title">Связаться с нами</h1>
                    <div class="head__img" id="arrow-contact"></div>
                </div>
                <p class="contact__desc">Отправьте нам сообщение. Мы свяжемся с вами и уточним все детали.</p>
            </div>
            <div class="contact__side">
                <form action="{{ route('feedback.post') }}" method="POST" name="formFeedback" class="contact-form contact__form">
                    {{csrf_field()}}
                    <input type="hidden" value="{{$page}}" name="page" />
                    <input class="contact-form__input" name="phone" type="text" placeholder="Телефон*">
                    <input class="contact-form__input" name="name" type="text" placeholder="Имя">
                    <textarea class="contact-form__input contact-form__area" name="msg" placeholder="Текст сообщения"></textarea>
                    <span class="contact-form__policy">Нажимая "Отправить" вы соглашаетесь с политикой обработки персональных данных</span>
                    <input class="contact-form__btn btn" type="submit" value="Отправить">
{{--                    <input type="hidden" id="g-recaptcha-response-feedback" name="recaptcha_response" value="">--}}
                </form>
            </div>
        </div>
    </div>
</section>

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
