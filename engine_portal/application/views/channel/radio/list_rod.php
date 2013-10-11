<style>
    ul.rod_list {
        list-style-type: none;
        padding: 0px;
        margin: 0px;
        font-size: 12px;
    }
    ul.rod_list li{
        border-bottom : 1px solid #697c8d;
        padding-top : 2px;
        padding-bottom : 2px;
    }

    ul.rod_list li a{
        color : #4d4d4d;
        text-decoration : none;
    }

    ul.rod_list li a:hover{
        color : #d31821;
        text-decoration : underline;
    }    

    .category-title-container {
        color: #151515;
        font-size: 17px;
        margin-bottom: 10px;
    }
    .sub-cat-title-container {
        width: 100%;
        height : auto;
        padding-top: 2px;
        padding-bottom: 2px;
        text-align: center;
        border: 1px solid #797979;
        border-radius: 5px;
    }
</style>

<div class="category-title-container">
    <?php echo $sod_category; ?>
    </div>
    <div class="sub-cat-title-container" style="text-overflow: ellipsis">
        <?php echo ucwords(strtolower($sod_title)); ?>
    </div>

    <ul class="rod_list">
        <?php
        $no = 1;
        foreach ($sod as $sod) {
            ?>

            <li><div class="ellipsis-container">
                    <a title="<?php echo ucwords(strtolower($sod->title)); ?>" href="javascript:void(0);" onclick='javascript:loadRODPlayer("Radio On Demand > <?php echo cleanString(ucwords(strtolower($sod->title))); ?>", "<?php echo $sod->file; ?>", "<?php echo $sod->attachment; ?>");'>
                        <?php echo $no . ". " . ucwords(strtolower($sod->title)); ?>
                    </a>
                </div>
            </li>

            <?php if ($no == 1) { ?>
                <script>
                            $(document).ready(function() {
                                loadRODPlayer("Radio On Demand > <?php echo cleanString($sod->title); ?>", "<?php echo $sod->file; ?>", "<?php echo $sod->attachment; ?>");
                            });
                </script>
                <?php
            }
            $no++;
        }
        ?>
    </ul>
