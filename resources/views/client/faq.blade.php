@extends('client/layouts/layoutMaster')

@section('title', 'FAQ')

@section('page-styles')
<!-- Place your custom styles here -->
@vite([
    'resources/assets/client/css/linearicons.css',
    'resources/assets/client/css/font-awesome.min.css',
    'resources/assets/client/css/themify-icons.css',
    'resources/assets/client/css/owl.carousel.css',
    'resources/assets/client/css/nice-select.css',
    'resources/assets/client/css/nouislider.min.css',
    'resources/assets/client/css/ion.rangeSlider.css',
    'resources/assets/client/css/ion.rangeSlider.skinFlat.css',
    'resources/assets/client/css/magnific-popup.css',
    'resources/assets/client/css/bootstrap.css',
    'resources/assets/client/css/main.css',
])
<style>
.faq-section {
    padding: 60px 0;
}
.faq-question {
    cursor: pointer;
    font-weight: 600;
}
.faq-answer {
    display: block;
    margin-top: 10px;
}
.faq-video {
    margin-top: 20px;
}
/* .faq-section *{
  justify-content: center;
  justify-items: center;
  text-align: center;
} */
</style>
@endsection

@section('page-content')

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="flex-wrap breadcrumb-banner d-flex align-items-center justify-content-end">
				<div class="col-first">
					<h1>Contactez Nous</h1>
					<nav class="d-flex align-items-center">
						<a href="{{ route("site.index") }}">Accueil<span class="lnr lnr-arrow-right"></span></a>
						<a href="#">FAQ</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
  <div class="mt-5 text-center">
      <h2>Foire aux Questions</h2>
      <p>Retrouvez ici toutes les réponses à vos questions sur nos parfums CHOGAN.</p>
  </div>
	<!-- End Banner Area -->
<section class="faq-section">
    <div class="container">
        <div class="mb-4 faq-item">
          <div class="faq-question">Les parfums CHOGAN sont-ils identiques aux grandes marques connues du marché ?</div>
          <div class="faq-answer">
            <p>Les parfums Chogan offrent une expérience olfactive proche des grandes marques, sans le prix élevé lié à la marque ou au packaging.</p>
            <div class="faq-video">
              <iframe width="560" height="315" src="https://www.youtube.com/embed/cJjoM-Lm2fI?si=F_lCYl15e0qZdyU-" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
          </div>
        </div>

        <div class="mb-4 faq-item">
          <div class="faq-question">Pourquoi je dois acheter un parfum CHOGAN plutôt qu'un autre parfum ?</div>
          <div class="faq-answer">
            <p>Chogan propose des parfums de qualité à prix abordable, en privilégiant l'essentiel : le parfum lui-même.</p>
            <div class="faq-video">
              <iframe width="560" height="315" src="https://www.youtube.com/embed/b2AxpHVpSug?si=Md5_aVx_oIKPM-2n" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
          </div>
        </div>

        <div class="mb-4 faq-item">
          <div class="faq-question">Pourquoi les parfums CHOGAN ne coûtent pas chers ?</div>
          <div class="faq-answer">
            <p>Chogan ne facture pas la marque, la publicité ni le packaging, ce qui leur permet de proposer des prix très compétitifs.</p>
            <div class="faq-video">
              <iframe width="560" height="315" src="https://www.youtube.com/embed/--qYfJklFGI?si=br72Wqpp8EYk4SQ0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>              
            </div>
          </div>
        </div>
    </div>
</section>
@endsection

@section('page-scripts')
	<!-- Place your custom scripts here -->
	@vite([
		'resources/assets/client/js/vendor/jquery-2.2.4.min.js',
		'resources/assets/client/js/jquery.ajaxchimp.min.js',
		'resources/assets/client/js/jquery.nice-select.min.js',
		'resources/assets/client/js/jquery.sticky.js',
		'resources/assets/client/js/nouislider.min.js',
		'resources/assets/client/js/countdown.js',
		'resources/assets/client/js/jquery.magnific-popup.min.js',
		'resources/assets/client/js/owl.carousel.min.js',
		//'resources/assets/client/js/gmaps.min.js',
	  'resources/assets/client/js/vendor/jquery-2.2.4.min.js',
    'resources/assets/client/js/vendor/bootstrap.min.js',
    'resources/assets/client/js/main.js',
	])

<script>
document.querySelectorAll('.faq-question').forEach(item => {
    item.addEventListener('click', () => {
        const answer = item.nextElementSibling;
        answer.style.display = answer.style.display === 'block' ? 'none' : 'block';
    });
});
</script>
@endsection
