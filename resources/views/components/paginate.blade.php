<?php

    $current_page = $response->current_page;
    $per_page = $response->per_page;
    $total = $response->total;
    $total_page = (int) ceil($total / $per_page);

    $initial_page = $current_page - 3 > 0 ? $current_page - 3 : 1;
    $last_page = $current_page + 3 < $total_page ? $current_page + 3 : $total_page;

?>

<div class="clearfix">
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" href="{{ $response->first_page_url }}" tabindex="-1"><<</a>
            </li>
            @for ($page = $initial_page; $page <= $last_page; $page++)
                <li class="page-item">
                    <a class="page-link" href="{{ $response->path.'?page='.$page }}">{{ $page }}
                    </a>
                </li>
            @endfor
            <li class="page-item">
                <a class="page-link" href="{{ $response->last_page_url }}">>></a>
            </li>
        </ul>
    </nav>
</div>