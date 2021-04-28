<?php
    $next = ($page + 1);
    $prev = ($page - 1);

    if( ($total % $limit) == 0){
        $last = (int) ($total / $limit);
    }else{
        $last = (int) ($total / $limit) + 1;
    }

    echo '<div class="pagination">';
    echo '<ul>';
            if($page > 1){
                if(isset($_GET['search'])){
                    echo '<li>';
                    echo '<a href="?page=' . $prev . '&search=' . urlencode($_GET['search']) . '">Previous</a>';
                    echo '</li>';
                    echo '<li>';
                    echo '<a href="?page=' . 1 . '&search=' . urlencode($_GET['search']) . '"> 1 </a>';
                    echo '</li>';
                    if( $page == 2){
                        echo '<li>';
                        echo '<a href="?page=' . $page . '&search=' . urlencode($_GET['search']) . '">'. $page .'</a>';
                        echo '</li>';
                    }
                    elseif( $page == 3 ){
                        for( $i = $page - 1; $i <= $page; $i++){
                            echo '<li>';
                            echo '<a href="?page=' . $i . '&search=' . urlencode($_GET['search']) . '">'. $i .'</a>';
                            echo '</li>';
                        }
                    }else{
                        for( $i = $page - 2; $i <= $page; $i++ ){
                            echo '<li>';
                            echo '<a href="?page=' . $i . '&search=' . urlencode($_GET['search']) . '">'. $i .'</a>';
                            echo '</li>';
                        }
                    }
                    $i = $page + 1;
                    while( $i <= ($page + 2) and $i < $last ){
                        echo '<li>';
                        echo '<a href="?page=' . $i . '&search=' . urlencode($_GET['search']) . '">'. $i .'</a>';
                        echo '</li>';
                        $i++;
                    }
                    if($page != $last ) {
                        echo '<li>';
                        echo '<a href="?page=' . $last . '&search=' . urlencode($_GET['search']) . '">'. $last .'</a>';
                        echo '</li>';
                        echo '<li>';
                        echo '<a href="?page=' . $next . '&search=' . urlencode($_GET['search']) . '">Next</a>';
                        echo '</li>';
                    }
                }else{
                    echo '<li>';
                    echo '<a href="?page=' . $prev . '">Previous</a>';
                    echo '</li>';
                    echo '<li>';
                    echo '<a href="?page=' . 1 . '"> 1 </a>';
                    echo '</li>';
                    if( $page == 2){
                        echo '<li>';
                        echo '<a href="?page=' . $page . '">'. $page .'</a>';
                        echo '</li>';
                    }
                    elseif( $page == 3 ){
                        for( $i = $page - 1; $i <= $page; $i++){
                            echo '<li>';
                            echo '<a href="?page=' . $i . '">'. $i .'</a>';
                            echo '</li>';
                        }
                    }else{
                        for( $i = $page - 2; $i <= $page; $i++ ){
                            echo '<li>';
                            echo '<a href="?page=' . $i . '">'. $i .'</a>';
                            echo '</li>';
                        }
                    }
                    $i = $page + 1;
                    while( $i <= ($page + 2) and $i < $last ){
                        echo '<li>';
                        echo '<a href="?page=' . $i . '">'. $i .'</a>';
                        echo '</li>';
                        $i++;
                    }
                    if($page != $last ) {
                        echo '<li>';
                        echo '<a href="?page=' . $last . '">'. $last .'</a>';
                        echo '</li>';
                        echo '<li>';
                        echo '<a href="?page=' . $next . '">Next</a>';
                        echo '</li>';
                    }
                }
            }else {
                if(isset($_GET['search'])){
                    echo '<li>';
                    echo '<a href="?page=' . 1 . '&search=' . urlencode($_GET['search']) . '"> 1 </a>';
                    echo '</li>';
                    for( $i = $page + 1; $i <= ($page + 2); $i++ ){
                        echo '<li>';
                        echo '<a href="?page=' . $i . '&search=' . urlencode($_GET['search']) . '">'. $i .'</a>';
                        echo '</li>';
                    }
                    echo '<li>';
                    echo '<a href="?page=' . $last . '&search=' . urlencode($_GET['search']) . '">'. $last .'</a>';
                    echo '</li>';
                    if($page * $limit < $total) {
                        echo '<li>';
                        echo '<a href="?page=' . $next . '&search=' . urlencode($_GET['search']) . '">Next</a>';
                        echo '</li>';
                    }
                }else{
                    echo '<li>';
                    echo '<a href="?page=' . 1 . '"> 1 </a>';
                    echo '</li>';
                    for( $i = $page + 1; $i <= ($page + 2); $i++ ){
                        echo '<li>';
                        echo '<a href="?page=' . $i . '">'. $i .'</a>';
                        echo '</li>';
                    }
                    echo '<li>';
                    echo '<a href="?page=' . $last . '">'. $last .'</a>';
                    echo '</li>';
                    if($page * $limit < $total) {
                        echo '<li>';
                        echo '<a href="?page=' . $next . '">Next</a>';
                        echo '</li>';
                    }
                }
            }
    echo '</ul>';
    echo '</div>';
?>