@extends('client/layouts/layoutMaster')

@section('title', 'FAQ')

@section('page-styles')
@vite([
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
    display: none;
    margin-top: 10px;
}
.faq-video {
    margin-top: 20px;
}
</style>
@endsection

@section('page-content')
<section class="faq-section">
    <div class="container">
        <div class="mb-5 text-center">
            <h2>Foire aux Questions</h2>
            <p>Retrouvez ici toutes les réponses à vos questions sur nos parfums CHOGAN.</p>
        </div>

        <div class="mb-4 faq-item">
          <div class="faq-question">Les parfums CHOGAN sont-ils identiques aux grandes marques connues du marché ?</div>
          <div class="faq-answer">
            <p>Les parfums Chogan offrent une expérience olfactive proche des grandes marques, sans le prix élevé lié à la marque ou au packaging.</p>
            <div class="faq-video">
              <iframe width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Video FAQ 1" frameborder="0" allowfullscreen></iframe>
            </div>
          </div>
        </div>

        <div class="mb-4 faq-item">
          <div class="faq-question">Pourquoi je dois acheter un parfum CHOGAN plutôt qu'un autre parfum ?</div>
          <div class="faq-answer">
            <p>Chogan propose des parfums de qualité à prix abordable, en privilégiant l'essentiel : le parfum lui-même.</p>
            <div class="faq-video">
              <iframe width="1328" height="747" src="https://www.youtube.com/embed/cJjoM-Lm2fI" title="Nos parfums : des créations Chogan concentrées à 30% en extrait de parfums" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
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
@vite(['resources/assets/client/js/main.js'])
<script>
document.querySelectorAll('.faq-question').forEach(item => {
    item.addEventListener('click', () => {
        const answer = item.nextElementSibling;
        answer.style.display = answer.style.display === 'block' ? 'none' : 'block';
    });
});
</script>
@endsection
