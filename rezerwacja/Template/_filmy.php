<?php
$filmy_shuffle = $filmy->getData();
$i = 1;
?>

<style>
    .item {
        display: none;
    }

    .show {
        display: inline-block;
    }
</style>
<section class="kategorie">
    <div class="container">
        <h4 class="pt-4" id="scrollTo">Kategorie</h4>
        <hr>
        <div id="filruj" role="group" aria-label="Kategorie">
            <button class="btn my-2" onclick="filter('all')">Wszystkie</button>
            <button class="btn border my-2" onclick="filter('scifi')">Sci-fi</button>
            <button class="btn border my-2" onclick="filter('komedie')">Komedie</button>
            <button class="btn border my-2" onclick="filter('dramat')">Dramat</button>
            <button class="btn border my-2" onclick="filter('edukacyjne')">Edukacyjne</button>
            <button class="btn border my-2" onclick="filter('akcja')">Akcja</button>
            <button class="btn border my-2" onclick="filter('animowane')">Animowane</button>
        </div>
</section>

<section class="filmy">
    <div class="grid">
        <div class="grid-item border border-2 px-5 py-5">
            <?php
            array_map(function ($item) {
                if (!isset($_GET['gatunek'])) {
                    ?>

                    <div class="item py-3 px-3 show <?php echo $item['gatunek_filmu'] ?? "Gatunek"; ?>"
                         style="max-width:250px;">
                        <div class="film ">
                            <img src="<?php echo $item['obrazek'] ?? "./images/filmy/filmy1dramat.jpg"; ?>"
                                 alt="plakat filmu" class="img-fluid">
                            <div class="text-center py-3">
                                <h6><?php echo $item['tytul'] ?? "Nieznany"; ?></h6>
                                <a href="ofilmie.php?id=<?php echo $item['id_film'] ?? ""; ?>">
                                    <button type="submit" class="btn btn-warning font-size-10 my-1">Zarezerwuj teraz
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                } elseif (isset($_GET['gatunek']) && ($item['gatunek_filmu'] == $_GET['gatunek'])) {
                    ?>

                    <div class="item py-3 px-3 show <?php echo $item['gatunek_filmu'] ?? "Gatunek"; ?>"
                         style="max-width:250px;">
                        <div class="film ">
                            <img src="<?php echo $item['obrazek'] ?? "./images/filmy/filmy1dramat.jpg"; ?>"
                                 alt="plakat filmu" class="img-fluid">
                            <div class="text-center py-3">
                                <h6><?php echo $item['tytul'] ?? "Nieznany"; ?></h6>
                                <a href="ofilmie.php?id=<?php echo $item['id_film'] ?? ""; ?>">
                                    <button type="submit" class="btn btn-warning font-size-10 my-1">Zarezerwuj teraz
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }, $filmy_shuffle) ?>
        </div>
    </div>

</section>
</main>
<script>
    function filter(val) {
        const x = document.getElementsByClassName("item");
        if (val == 'all') {
            val = '';
        }
        for (i = 0; i < x.length; i++) {
            removeClass(x[i], "show");
            if (x[i].className.indexOf(val) > -1) addClass(x[i], "show");
        }
    }

    function addClass(element, name) {
        var i, arr1, arr2;
        arr1 = element.className.split(" ");
        arr2 = name.split(" ");
        for (i = 0; i < arr2.length; i++) {
            if (arr1.indexOf(arr2[i]) == -1) {
                element.className += " " + arr2[i];
            }
        }
    }

    function removeClass(element, name) {
        var i, arr1, arr2;
        arr1 = element.className.split(" ");
        arr2 = name.split(" ");
        for (i = 0; i < arr2.length; i++) {
            while (arr1.indexOf(arr2[i]) > -1) {
                arr1.splice(arr1.indexOf(arr2[i]), 1);
            }
        }
        element.className = arr1.join(" ");
    }
</script>