<?php defined('C5_EXECUTE') or die("Access Denied.");
?>

<table class="table table-responsive">
<?php
foreach($cvlist as $cvl){
?>
<pre><?php var_dump($cvl)?></pre>
<tr><td>
    <div class="row">
        <?php
        $page = Page::getByID($cvl['cID']);
        $permissions = new Permissions($page);
        ?>
        <div class="col-sm-2">
            <h4><?php echo h($page->getCollectionName())?></h4>
            <ul>
                <li>
                    <?php $nh = Core::make('helper/navigation'); ?>
                    <a href="<?php echo $nh->getLinkToCollection($page)?>"><?php echo t('Visit')?></a>
                </li>
                <?php if($permissions->canViewPageVersions()) { ?>
                    <li><a class="dialog-launch" dialog-width="640" dialog-height="340"
                       dialog-modal="false" dialog-title="<?php echo t('Versions') ?>" href="<?php echo URL::to(
                        '/ccm/system/panels/page/versions') ?>?cID=<?php echo $page->getCollectionID() ?>"><?php echo t('Versions')?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="col-sm-10">
            <div data-search-element="results">
                <div class="table-responsive">
                    <table  id="ccm-collectionversioncheck" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="col-sm-2"><span>バージョン</span></th>       
                                <th class="col-sm-5"><span>コメント</span></th>            
                                <th class="col-sm-3"><span>作成日</span></th>            
                                <th class="col-sm-2"><span>承認</span></th>            
                            </tr>
                        </thead>
                        <?php
                        foreach($cvl as $cv){
                            if($cv->cvID){
                        ?>
                                <tr class="<?php echo $cv->cvIsApproved == 1 ? 'success' : ''?>">
                                    <td><?php echo h($cv->cvID);?> </td>
                                    <td><?php echo h(substr($cv->cvComments,0,20)) ;?> </td>
                                    <td><?php echo h($cv->cvDateCreated);?> </td>
                                    <td><?php echo $cv->cvIsApproved == 1 ? t('Approved') : '' ?> </td>
                                </tr>
                                
                        <?php
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</td></tr>
<?php } ?>
</table>