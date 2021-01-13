<?php

    $current_page = $paginator->currentPage();
    $per_page = $paginator->perPage();
    $total = $paginator->total();
    $total_page = (int) ceil($total / $per_page);

    $initial_page = $current_page - 3 > 0 ? $current_page - 3 : 1;
    $last_page = $current_page + 3 < $total_page ? $current_page + 3 : $total_page;
?>

@if ($paginator->hasPages())
    <div class="clearfix">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($paginator->onFirstPage()) }}"><<</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}"><</a>
                </li>
                @foreach ($paginator->getUrlRange($initial_page, $last_page) as $page => $url)
                    <li class="page-item">
                        <a class="page-link {{ $current_page == $page ? 'text-white bg-danger' : ''}}" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}">></a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">>></a>
                </li>
            </ul>
        </nav>
    </div>
@endif