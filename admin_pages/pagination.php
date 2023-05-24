<?php
    $start = max(1, $curr_page - 5);
    $end = min($num_pages, $curr_page + 5);

    if ($privious_page_disable) {
        echo "<span style='color: #878787;cursor: auto;'>&lt; previous</span>";
    } else {
        echo "<a href='?page=$privious_page&per-pages=$num_pages&'>&lt; previous</a>";
    };

    for ($i = $start; $i <= $end; $i++) {
        if ($i == $curr_page) {
            echo "<span style='color:white;background: #878787;padding: 5px;border-radius: 50%;font-size: 17px;'>$i</span>";
        } else {
            echo "<a href='?page=$i&per-pages=$num_pages&'>$i</a>";
        }
    };

    if ($next_page_disable) {
        echo "<span style='color: #878787;cursor: auto;'>next &gt;</span>";
    } else {
        echo "<a href='?page=$next_page&per-pages=$num_pages&'>next&gt;</a>";
    };
?>