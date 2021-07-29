<?php if (is_numeric($params['score']) && $params['score'] != 0) : ?>
    <?php
    if ($params['score'] >= 0 && $params['score'] <= 49) {
        $color = 'red';
    } elseif ($params['score'] >= 50 && $params['score'] <= 89) {
        $color = 'orange';
    } elseif ($params['score'] >= 90 && $params['score'] <= 100) {
        $color = 'green';
    }
    ?>
    <div class="circle <?php echo $color ?>">
        <?php if(empty($params['link'])): ?>
            <div class="circle__value"><?php echo $params['score'] ?></div>
        <?php else: ?>
            <a href="<?php echo $params['link'] ?>" target="_blank" class="circle__value"><?php echo $params['score'] ?></a>
        <?php endif ?>
        <svg width="<?php echo $params['radius'] * 2 + $params['stroke'] ?>" height="<?php echo $params['radius'] * 2 + $params['stroke'] ?>">
            <circle cx="<?php echo $params['radius'] - $params['stroke']/2 ?>" cy="<?php echo $params['radius'] - $params['stroke']/2 ?>" r="<?php echo $params['radius'] ?>"></circle>
            <circle cx="<?php echo $params['radius'] - $params['stroke']/2 ?>" cy="<?php echo $params['radius'] - $params['stroke']/2 ?>" r="<?php echo $params['radius'] ?>" style="stroke-dasharray: calc(<?php echo $params['score'] ?>/100*2*3.14*<?php echo $params['radius'] ?>) calc(2*3.14*<?php echo $params['radius'] ?>)"></circle>
        </svg>
    </div>
<?php else : ?>
    <div>--</div>
<?php endif ?>