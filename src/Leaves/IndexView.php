<?php

namespace HackTheHub\Leaves;

use HackTheHub\Models\Event\Category;
use Rhubarb\Leaf\Leaves\LeafDeploymentPackage;
use Rhubarb\Leaf\Views\View;
use Rhubarb\Stem\Filters\Equals;

class IndexView extends View
{
    protected function printViewContent()
    {
        ?>

        <div class="top-nav">
            <button onclick="slideout.open(); return false" class="mopen">MENU</button>
        </div>

        <div class="map" id="map"></div>
        <main id="panel">
            <header>
            </header>
        </main>

        <nav id="menu">
            <header>
                <button onclick="slideout.close(); return false;" class="mclose" id="side-close">X</button>
                <button onclick="doCollapse(); return false;" class="mclose" id="full-close">X</button>
                <div class="profile">
                    <img src="/static/pfp.png" style="width:100px; height:100px; border-radius:100%;">
                    <p>BOYD IRELAND</p>
                </div>
                <div id="hideOnExtend">
                    <button class="side-button settings">LET ME SEE...</button>
                    <div class="see-me" >
                        <?php
                        foreach(Category::find(new Equals('ParentCategoryID', 0)) as $category) {
                            print '<input type="checkbox" name="category-' . $category->Name . '" class="category-filter" data-id="' . $category->CategoryID . '"/><label for="category-' . $category->Name . '" class="checkbox-custom-label"></label><span class="cat-pick">' . $category->Name . '</span><br><br>';
                            unset($category);
                        }
                        ?>
                    </div>
                    <button class="side-button settings" onClick="doExtend(); return false;">SETTINGS</button>
                </div>


                <div class="user-settings" id="user-settings">
                    <h1 class="settings-title">Account Settings</h1>
                    <p class="settings-detail">Change your basic account settings here</p>
                    <h2 class="settings-detail">Refine View</h2>
                    <div class="SUB-CATS-HERE">
                        <!--SUB CATS GO HERE-->
                    </div>
                    <h2 class="settings-detail">Security</h2>
                    <input type="password" placeholder="New Password" class="settings-input">
                    <input type="password" placeholder="New Password Again" class="settings-input">
                    <br>
                    <button class="update">Update</button>
                </div>

            </header>
        </nav>

        <script>
            function doExtend() {
                document.getElementById("menu").style.transition = "1s";
                document.getElementById("menu").style.width = "100%";
                document.getElementById("user-settings").style.display = "inline-block";
                //hide these elements
                document.getElementById("hideOnExtend").style.display = "none";
                document.getElementById("side-close").style.display = "none";
                document.getElementById("full-close").style.display = "inline";

            }

            function doCollapse() {
                document.getElementById("menu").style.transition = "1s";
                document.getElementById("menu").style.width = "256px";
                document.getElementById("user-settings").style.display = "none";
                //show these
                document.getElementById("hideOnExtend").style.display = "inline";
                document.getElementById("full-close").style.display = "none";
                document.getElementById("side-close").style.display = "inline";
            }

            function showFullEvent() {
                document.getElementById("popHide").style.display = "inline";
            }

            function hideFullEvent() {
                document.getElementById("popHide").style.display = "none";
            }

            var slideout = new Slideout({
                'panel': document.getElementById('panel'),
                'menu': document.getElementById('menu'),
                'padding': 256,
                'tolerance': 0
            });
        </script>

        <script type="text/javascript">
            //extend side menu
            function doExtend()
            {
                document.getElementById("menu").style.transition="1s";
                document.getElementById("menu").style.width="100%";
                //hide these elements
                document.getElementById("hideOnExtend").style.display="none";
                document.getElementById("side-close").style.display="none";
                document.getElementById("full-close").style.display="inline";

            }

            function doCollapse()
            {
                document.getElementById("menu").style.transition="1s";
                document.getElementById("menu").style.width="256px";
                //show these
                document.getElementById("hideOnExtend").style.display="inline";
                document.getElementById("full-close").style.display="none";
                document.getElementById("side-close").style.display="inline";
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAg4EuXhENQ2kETW0x6U-hg_r7u82r89Wo&callback=initMap" async defer></script>

        <?php
    }

    public function getDeploymentPackage()
    {
        $package = new LeafDeploymentPackage();
        $package->resourcesToDeploy[] = __DIR__ . '/' . $this->getViewBridgeName() . '.js';
        return $package;
    }

    protected function getViewBridgeName()
    {
        return 'IndexViewBridge';
    }
}