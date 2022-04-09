<@Page>
    <main>
    <section class="full-product">
        <div class="product section-style">
            <div class="product-name">
                <?php

                $product = new \app\Model\Products\Product();
                $product_type = new \app\Model\ProductType\product_type();
                $type = isset($_GET["pro_type"]) ? $_GET["pro_type"] : 1;
                $product->get($Uri);
                $product->next();
                $product_type->get($product->Pro_Id, $type);
                $product_type->next();
                echo $product->Pro_name;
                ?>
            </div>
            <div class="product-slider">
                <?php
                if ($product_type->offer > 0) {
                    echo '<div class="pro-offer">';
                    echo $product_type->offer;
                    echo '% off </div>';
                }
                $i = new \app\Model\Images\Images();
                $i->get($product->Pro_Id);
                while ($i->next()) {
                    ?>
                    <img src="<?= $i->image ?>" alt="">
                    <?php
                }
                ?>
            </div>

        </div>
        <div class="product-information">

            <div class="style-name section-style">
                <div class="product-name product-name-second-copy">
                    <?= $product->Name; ?>
                </div>
                <div class="style-name-title">
                    Style Name:
                    <?php
                    echo $product_type->Name;
                    ?>
                </div>
                <div class="product-varieties myslider-container">
                    <div class="myslider">
                        <?php
                        $product_type->get($product->Pro_Id);
                        while ($product_type->next()) {
                            ?>
                            <div class="myslider-item">
                                <a href="<?= HTTP_HOST . 'product/' . $product->Pro_uri . '?pro_type=' . $product_type->Id ?>"
                                   class="product-variety <?= $type == $product_type->Id ? 'selected' : '' ?>">
                                    <span><?= $product_type->name; ?></span>
                                    <span class="price"><?= number_format($product_type->price);; ?></span>
                                    <span class="<?= $product_type->Qty > 0 ? 'instock' : 'outofstock' ?>">
                                        <?php
                                        if ($product_type->Qty > 0) {
                                            echo "in stoke";
                                        } else {
                                            echo "out of stoke";
                                        }
                                        ?>

                                    </span>
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                </div>
            </div>
            <div class="section-style product-total-pricing">
                <div class="discount-price">
                    <span>MRP:</span>
                    <span class="price">
                        <?php
                        $product_type->get($product->Pro_Id, $type);
                        $product_type->next();
                        echo number_format($product_type->price);
                        ?>
                    </span>

                </div>
                <div class="real-price">
                    <span class="price">
                        <?php
                        $amount = $product_type->price - (($product_type->price / 100) * $product_type->offer);
                        echo number_format($amount);
                        ?>
                    </span>
                    <span class="save">
                        <span>Save</span>
                        <span class="price">
                            <?php
                            $amount = (($product_type->price / 100) * $product_type->offer);
                            echo number_format($amount);
                            ?>
                        </span>
                    </span>
                </div>


            </div>
            <div class="section-style product-pricing">
                <div>Details</div>
                <table>
                    <?= $product->Pro_Details ?>
                </table>
            </div>
            <div class="section-style buy-product">
                <div class="total-price">
                    <span>Total:</span>
                    <span class="price">
                        <?php
                        $amount = ($product_type->price - (($product_type->price / 100) * $product_type->offer));
                        echo number_format($amount);
                        ?></span>
                </div>
                <span class="<?= $product_type->Qty > 0 ? 'instock' : 'outofstock' ?>">
                    <?php
                    if ($product_type->Qty > 0) {
                        echo "in stoke";
                    } else {
                        echo "out of stoke";
                    }
                    ?>

                </span>
                <div class="buy-product-buttons">
                    <button>Buy Now</button>
                    <button>Add To Cart</button>
                </div>
            </div>
            <div class="section-style pro-disc">
                <div class="pro-dis-head">Product Description</div>
                <div class="discription">
                    <?= $product->Pro_description ?>
                </div>
            </div>
        </div>
        <div class="section-style you-may-also-like-slider myslider-container">
            <div class="YouMayAlsoLikeHeading">You May Also Like</div>
            <div class="myslider">
                <?php
                $youmaylikeProducts = new \app\Model\Products\product();
                $youmaylikeProducts->getbytags($product->Pro_tag);
                while ($youmaylikeProducts->next()) {
                    $i2 = new \app\Model\Images();
                    $i2->get($youmaylikeProducts->Pro_Id);
                    $i2->next();
                    $product_type2 = new \app\Model\ProductType\product_type();
                    $product_type2->get($youmaylikeProducts->Pro_Id);
                    $product_type2->next();
                    ?>
                    <div class="myslider-item">
                        <div class="YouMayAlsoLike">
                            <img src="<?= $i2->image ?>">
                            <a href="<?= HTTP_HOST . "product/" . $youmaylikeProducts->Pro_uri ?>"
                               class="product-name"><?= $youmaylikeProducts->Pro_name ?></a>
                            <div class="price"><?= $product_type2->price ?></div>
                        </div>
                    </div>
                    <?php
                }
                ?>


            </div>
            <script>
                isdragging = false;
                startScrolling = 0;
                slided = 0;
                newSlided = 0;
                let mysliders = document.querySelectorAll(".myslider");
                mysliders.forEach(function (myslider) {
                    let myslider_con;
                    myslider.addEventListener("mousedown", function (a) {
                        myslider_con = this.parentElement;
                        myslider_con.classList.add("grabbing");
                        startScrolling = a.pageX;
                        isdragging = true;
                    });
                    myslider.addEventListener("mouseup", function () {
                        myslider_con.classList.remove("grabbing");
                        slided = newSlided;
                        isdragging = false;
                    });
                    myslider.addEventListener("mouseenter", function () {
                        myslider_con = this.parentElement;
                    });
                    myslider.addEventListener("mouseout", function () {
                        myslider_con.classList.remove("grabbing");
                        slided = newSlided;
                        isdragging = false;
                    });
                    myslider.addEventListener("mousemove", function (a) {
                        if (isdragging) {
                            newSlided = (a.pageX - startScrolling) + slided;

                            if (newSlided <= (myslider_con.offsetWidth - myslider.offsetWidth)) {
                                newSlided = (myslider_con.offsetWidth - myslider.offsetWidth);
                            } else if (newSlided > 0) {
                                newSlided = 0;
                            }
                            myslider.style.transform = `translateX(${newSlided}px)`;
                        }
                    });
                })

            </script>
        </div>


        <div class="section-style product-QA">
            <h3>Have a Question</h3>
            <input class="question" type="text" placeholder="Type your Question">
            <div class="QA-box">

            </div>
        </div>
    </section>
</main>
<@Page>