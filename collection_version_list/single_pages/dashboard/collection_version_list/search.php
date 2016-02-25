<?php defined('C5_EXECUTE') or die("Access Denied.");
?>
<form role="form" method="get" data-search-form="pagetypes" action="<?php echo $view->action('load_pagetype') ?>" class="ccm-search-fields">
    <div class="ccm-search-fields-row form-inline">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-7">
                    <?php echo t('page type') ?>:
                    <select name="ptID">
                        <option value ="0" <?php echo $ptID == 0 ? 'selected' : '' ?> ><?php echo h('None') ?></option>
                        <?php foreach ($pts as $pt) { ?>
                            <option value ="<?php echo $pt->ptID ?>" <?php echo $pt->ptID == $ptID ? 'selected' : '' ?> ><?php echo $pt->ptName ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-5">
                    <input type="checkbox" name="lastestversion" value="1" <?php echo $lastestversion ? "checked" : "" ?>>最新バージョンが承認されていない
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary pull-right"><?php echo t('Search') ?></button>
</form>

<table class="table table-responsive">
    <?php
// $page_result = json_decode(json_encode($page_result));
    foreach ($cvlresult as $cvl) {
        $page = Page::getByID($cvl['cID']);
        $cp = new Permissions($page);
        if ($cp->canViewPageVersions()) {
            ?>
            <tr><td>
                    <div class="row">
                        <div class="col-sm-3">
                            <h4><?php echo h($page->getCollectionName()) ?></h4>
                            <ul>
                                <li>
                                    <?php $nh = Core::make('helper/navigation'); ?>
                                    <a href="<?php echo $nh->getLinkToCollection($page) ?>"><?php echo t('Visit') ?></a>
                                </li>
                                <li><a class="dialog-launch" dialog-width="640" dialog-height="340"
                                       dialog-modal="false" dialog-title="<?php echo t('Versions') ?>" href="<?php echo URL::to(
                                    '/ccm/system/panels/page/versions')
                                    ?>?cID=<?php echo $page->getCollectionID() ?>"><?php echo t('Versions') ?></a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-9">
                            <div data-search-element="results">
                                <div class="table-responsive">
                                    <table  id="ccm-collectionversioncheck" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="col-sm-2"><span><?php echo t('Version') ?></span></th>       
                                                <th class="col-sm-6"><span><?php echo t('Comments') ?></span></th>            
                                                <th class="col-sm-4"><span><?php echo t('Modified') ?></span></th>            
                                            </tr>
                                        </thead>
                                        <?php
                                        foreach ($cvl['vObj'] as $cv) {
                                            ?>
                                            <tr class="<?php echo $cv->cvIsApproved == 1 ? 'success' : '' ?>">
                                                <td><?php echo h($cv->cvID); ?> </td>
                                                <td><?php echo h(substr($cv->cvComments, 0, 20)); ?> </td>
                                                <td><?php echo h($cv->cvDateCreated); ?> </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </td></tr>
        <?php } ?>
<?php } ?>
</table>
<?php if ($showPagination): ?>
    <div class="ccm-search-results-pagination">
        <ul class="pagination">
            <li class="prev"><?php echo $paginator->getPrevious() ?></li>
            <?php echo $paginator->getPages('li') ?>
            <li class="next"><?php echo $paginator->getNext() ?></li>
        </ul>
    </div>
<?php endif; ?>
