<div class = "container col-sm-12">
    <div class = "row">
        <div class = "col-sm-4 text-center">
            <div class="homeslider-container">
                <ul class="rslides">
                 {foreach $products as $product}
                      <li class="slide">
                          <a href="{$category[0].link_rewrite}/{$product.id_product}-{$product.link_rewrite}.html">
                          <img src="{$image}" alt="{$product.name}" width="250" heigth="250"/>
                           <h3>{$product.name}</h3>
                          </a>
                     </li>
                {/foreach}
              </ul>
            </div>
        </div>
        <div class = "col-sm-7">
                <h3>CATEGORIA DESTACADA</h3>
                <p>Lorem </p>
        </div>
    </div>
</div>
