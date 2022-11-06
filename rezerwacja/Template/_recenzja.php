<?php
$display = true;
if($review->isReviewAdded($_GET['id'], $_SESSION['id'])) $display = false;
?>
<div id="main_review" class="row" <?php if(!$display) echo 'style="display: none"';?> >
    <div class="col-md-12">
        <form method="post" action="addReview.php" id="form">
            <span id="error" style="color:red; display: none">Musisz zostawić ocenę:</span>
            <div id="stars" style="display: flex; flex-direction: row; margin-bottom: 1rem">
                <input type="hidden" name="rating" id="rating">
                <input type="hidden" name="reviewId" id="reviewId">
                <input type="hidden" name="id_film" id="id_film" value="<?php echo $_GET['id']; ?>">
            </div>
            <textarea required class="form-control" id="mainComment" placeholder="Napisz recenzję..." cols="30"
                      rows="" name="reviewText"></textarea><br>

            <select name="visibility" id="visibility" style="display: none">
                <option value="0">Widoczna tylko dla mnie</option>
                <option value="1">Widoczna dla wszystkich</option>
            </select>

            <button type="button" style="float:right; padding: 0.5rem; margin-left: 1rem; display: none" class="btn btn-danger" id="cancelEdition">Anuluj</button>
            <button type="button" style="float:right; padding: 0.5rem" class="btn btn-warning" id="addComment">Dodaj</button>
        </form>
    </div>
</div>

<svg id="star" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
     class="bi bi-star-fill rating-star" viewBox="0 0 16 16" style="display: none">
    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
</svg>

<script type="text/javascript">

    let starsDiv = document.getElementById('stars');
    let stars = [];
    let star = document.getElementById('star');
    let isSet = false;
    let rating = 0;
    let ratingInput = document.getElementById('rating');
    let errorDiv = document.getElementById('error');
    ratingInput.value = 0;
    let comment = document.getElementById('mainComment');
    let addCommentButton = document.getElementById('addComment');
    addCommentButton.addEventListener('click', () => {
        addReview();
    });
    let cancelEditionButton = document.getElementById('cancelEdition');
    cancelEditionButton.addEventListener('click', () => {
        cancelEdition();
    })
    let form = document.getElementById('form');
    for (let i = 0; i < 5; i++) {
        stars.push(star.cloneNode(true));
        stars[i].style = "";
        stars[i].addEventListener('mouseenter', () => {
            hoverStar(i);
        });
        stars[i].addEventListener('click', () => {
            rate(i);
        });
        starsDiv.addEventListener('mouseleave', () => {
            leaveRating();
        });
        starsDiv.append(stars[i]);
    }

    function hoverStar(id) {
        clearSelection();

        for(let i = 0; i <= id; i++){
            stars[i].style.fill = "gold";
        }
    }
    function leaveRating(){
        clearSelection();
        if(isSet){
            for(let i = 0; i < rating; i++){
                stars[i].style.fill = "gold";
            }
        }
    }

    function clearSelection(){
        for(let i = 0; i < 5; i++){
            stars[i].style.fill = "black";
        }
    }

    function rate(id){
        rating = id + 1;
        isSet = true;
        ratingInput.value = rating;
        errorDiv.style.display = "none";
    }

    function addReview(){
        if(rating === 0){
            errorDiv.style.display = "block";
        }else{
            if(addCommentButton.innerHTML === "Zapisz"){
                form.action = "updateReview.php";
            }else{
                form.action = "addReview.php";
            }
            form.submit();
        }
    }

    function startEdition(rating, text, id, user_id, review_user_id, visible){
        document.getElementById('main_review').style.display = "block";
        document.getElementById('reviewId').value = id;
        comment.innerHTML = text;
        addCommentButton.innerHTML = "Zapisz";
        cancelEditionButton.style.display = "Block";
        document.getElementById('visibility').style.display = user_id === review_user_id ? 'block' : 'none';
        document.getElementById('visibility').selectedIndex = visible;
        setRating(rating);
    }

    function setRating(comRating){
        rating = comRating;
        ratingInput.value = rating;
        for(let i = 0; i < 5; i++){
            if(i < comRating) {
                stars[i].style.fill = "gold";
            }else{
                stars[i].style.fill = "black";
            }
        }
    }

    function cancelEdition(){
        document.getElementById('main_review').style.display = "none";
        comment.innerHTML = "";
        addCommentButton.innerHTML = "Dodaj";
        cancelEditionButton.style.display = "None";
        clearSelection();
        isSet = false;
        rating = 0;
        window.location.reload();
    }
</script>
