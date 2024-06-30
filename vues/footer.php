<footer class="bg-lightdark-grey fixed-bottom" >
    <div class="navbar d-flex justify-content-center">
        <a class="page-link paginationFirstLast" href="<?=$url.'/1'?>" <?php if($page==1) echo "style='pointer-events: none;'";?>>&lt&lt</a>
        <ul class="pagination m-0">
            <li class="page-item"><a class="page-link" href="<?=$url.'/'.(($page<=1)?($page):($page-1))?>" <?php if($page==1) echo "style='pointer-events: none;'";?>>&lt</a></li>
            <li class="page-item disabled"><a class="page-link"><?=$page?></a></li>
            <li class="page-item"><a class="page-link" href="<?=$url.'/'.(($page>=$nbPages)?($page):($page+1))?>" <?php if($page==$nbPages) echo "style='pointer-events: none;'";?>>&gt</a></li>
        </ul>
        <a class="page-link paginationFirstLast" href="<?=$url.'/'.$nbPages?>" <?php if($page==$nbPages) echo "style='pointer-events: none;'";?>>&gt&gt</a>
    </div>
</footer>