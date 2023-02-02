<nav aria-label="breadcrumb" style="margin-top: 3px;">
    <ol class="breadcrumb">
        <?php
        foreach ($this->crumbs as $crumb) {
            if (isset($crumb['url'])) {
                echo "<li class='breadcrumb-item'>";
                echo CHtml::link($crumb['name'], $crumb['url']);
                echo "</li>";
            } else {
                echo "<li class='breadcrumb-item active'><a href='#'>";
                echo $crumb['name'];
                echo "</a><li>";
            }
            /*if(next($this->crumbs)) {
                echo $this->delimiter;
            }*/
        }
        ?>
    </ol>
</nav>