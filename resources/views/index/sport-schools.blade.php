<section class="directions section">
    <div class="container">
        <div class="directions__inner">
            <div class="directions__head head"><h1 class="directions__title">направления</h1>
                <div class="head__img" id="directions-arrows"></div>
            </div>
            <div class="directions__items">
                @foreach($sportSchools as $sportSchool)
                    <a class="directions__item card" href="{{ $sportSchool->url }}">
                        <div class="directions__item-nav">
                            <div class="directions__link arrow">
                                <div class="arrow__circle"></div>
                                <img class="directions__linkImg" src="/images/icons/arrow.svg" alt="">
                            </div>
                            <img class="directions__icon" src="{{ $sportSchool->icon }}" alt="">
                        </div>
                        <h2 class="directions__title">{{ $sportSchool->name }}</h2>
                        <p class="directions__desc">{{ $sportSchool->main_text }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>