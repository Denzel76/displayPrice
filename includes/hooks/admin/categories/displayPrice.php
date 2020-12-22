<?php
/*
  Copyright (c) 2020, Denzel

  This work is licensed under a
  Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.

  You should have received a copy of the license along with this work.
  If not, see <http://creativecommons.org/licenses/by-nc-nd/4.0/>.
*/

class hook_admin_categories_displayPrice {
  var $version = '1.0.0';

  function listen_injectDataForm() {
    global $pInfo, $base_url;

    $this->load_lang();

    if (!isset($pInfo->products_dp)) {
      $pInfo->products_dp = '1';
    }
    $no_display = ('0' === $pInfo->products_dp);
    $yes_display = !$no_display;
    
    $product_display_price  = TEXT_PRODUCT_DISPLAY_PRICE_LABEL;

    $dp_input_yes = tep_draw_selection_field('products_dp', 'radio', '1', $yes_display, 'id="pdp1" class="custom-control-input"') . '<label class="custom-control-label" for="pdp1">' . TEXT_PRODUCT_DISPLAY_PRICE_YES . '</label>';
    $dp_input_no = tep_draw_selection_field('products_dp', 'radio', '0', $no_display, 'id="pdp0" class="custom-control-input"') . '<label class="custom-control-label" for="pdp0">' . TEXT_PRODUCT_DISPLAY_PRICE_NO . '</label>';

    $output = <<<EOD

        <div class="form-group row align-items-center" id="zDisplayPrice">
          <label class="col-form-label col-sm-3 text-left text-sm-right">{$product_display_price}</label>
          <div class="col-sm-9">
            <div class="custom-control custom-radio custom-control-inline">
              {$dp_input_yes}
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              {$dp_input_no}
            </div>
          </div>
        </div>
        
EOD;

      return $output;
    }

    function listen_productActionSave() {
      global $products_id;

      $products_displayPrice = tep_db_prepare_input($_POST['products_dp']);

      tep_db_query("update products set products_dp = '" . tep_db_input($products_displayPrice) . "' where products_id = '" . (int)$products_id . "'");
    }

    function listen_preDuplicateCopyToConfirmAction($parameters) {

      $parameters['db']['products']['products_dp'] = null;

    }

    function load_lang() {
      global $language;

      require(DIR_FS_CATALOG . 'includes/languages/' . $language . '/hooks/admin/categories/displayPrice.php');
    }

  }
