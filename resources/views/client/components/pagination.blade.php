@php
    $current = $element->currentPage();
    $last = $element->lastPage();
@endphp
<div class="filter-bar d-flex flex-wrap align-items-center">
  <div class="sorting mr-auto">
    {{-- <select>
      <option value="6">Afficher 6</option>
      <option value="9">Afficher 9</option>
      <option value="12">Afficher 12</option>
    </select> --}}
    <p class="result-count" style="color: white">Affichage {{ $element->count() }} sur {{ $element->total() }} résultats</p>
  </div>
  <div class="pagination">
    {{-- Lien précédent --}}
    @if ($element->onFirstPage())
        {{-- <span class="prev-arrow disabled"><i class="fa fa-long-arrow-left"></i></span> --}}
    @else
        <a href="{{ $element->previousPageUrl() }}" class="prev-arrow"><i class="fa fa-long-arrow-left"></i></a>
    @endif

    {{-- Liens de pages --}}
    @php
        $dotsBefore = false;
        $dotsAfter = false;
    @endphp

    @foreach ($element->getUrlRange(1, $last) as $page => $url)
        @if ($page == 1 || $page == $last || abs($page - $current) <= 1)
            {{-- Page de début, fin ou autour de la page active --}}
            @if ($page == $current)
                <a href="javascript:void(0);" class="active">{{ $page }}</a>
            @else
                <a href="{{ $url }}">{{ $page }}</a>
            @endif
        @elseif ($page < $current && !$dotsBefore)
            {{-- Dot avant la page active --}}
            <a href="javascript:void(0);" class="dot-dot"><i class="fa fa-ellipsis-h"></i></a>
            @php $dotsBefore = true; @endphp
        @elseif ($page > $current && !$dotsAfter)
            {{-- Dot après la page active --}}
            <a href="javascript:void(0);" class="dot-dot"><i class="fa fa-ellipsis-h"></i></a>
            @php $dotsAfter = true; @endphp
        @endif
    @endforeach

    {{-- Lien suivant --}}
    @if ($element->hasMorePages())
        <a href="{{ $element->nextPageUrl() }}" class="next-arrow"><i class="fa fa-long-arrow-right"></i></a>
    @else
        {{-- <span class="next-arrow disabled"><i class="fa fa-long-arrow-right"></i></span> --}}
    @endif
  </div>
</div>
