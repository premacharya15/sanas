<?php
$imageEnable = sanas_options('sanas_enable_rsvp_image', false);
$rsvpImage = sanas_options('sanas_rsvp_image');
global $current_user;
wp_get_current_user();
$user_id = $current_user->ID;
?>
    <div class="wl-left-slide-bar">
        <div class="d-flex inner-colum">
            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active" id="v-pills-text-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-text" type="button" role="tab" aria-controls="v-pills-text"
                    aria-selected="true">
                    <i class="icon-Text"></i>
                    <span>Text</span>
                </button>
                <button class="nav-link next" id="v-pills-background-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-background" type="button" role="tab" aria-controls="v-pills-background"
                    aria-selected="false">
                    <i class="icon-Background"></i>
                    <span>Background</span>
                </button>
                <button class="nav-link diseble h-100" id="v-pills-diseble-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-diseble" type="button" role="tab" aria-selected="false" tabindex="-1">
                </button>
                <button class="nav-link diseble h-100" id="v-pills-diseble-tab1" data-bs-toggle="pill"
                    data-bs-target="#v-pills-diseble" type="button" role="tab" aria-selected="false" tabindex="-1">
                </button>
                <button class="nav-link diseble" id="v-pills-diseble-tab2" data-bs-toggle="pill"
                    data-bs-target="#v-pills-diseble" type="button" role="tab" aria-selected="false" tabindex="-1">
                </button>
            </div>
            <div class="tab-content" id="v-pills-tabcontent">
                <div class="tab-pane fade active show" id="v-pills-text" role="tabpanel"
                    aria-labelledby="v-pills-text-tab" tabindex="0">
                    <?php 
                    if(wp_is_mobile())
                    {    
                    ?>
                    <div class="mobail-tab">
                        <ul class="nav nav-tabs" id="mobaile-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="font-tab" data-bs-toggle="tab"
                                    data-bs-target="#font-tab-pane" type="button" role="tab"
                                    aria-controls="font-tab-pane" aria-selected="true">Font</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="align-tab" data-bs-toggle="tab"
                                    data-bs-target="#align-tab-pane" type="button" role="tab"
                                    aria-controls="align-tab-pane" aria-selected="false">Align</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="color-tab" data-bs-toggle="tab"
                                    data-bs-target="#color-tab-pane" type="button" role="tab"
                                    aria-controls="color-tab-pane" aria-selected="false">Color</button>
                            </li>
                            <li>
                                <button class="cloes-btn">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="mobaile-tabcontent">
                            <div class="tab-pane fade show active" id="font-tab-pane" role="tabpanel"
                                aria-labelledby="font-tab" tabindex="0">
                                <div class="mobaile-form-text-edit">
                                    <div class="form-group-outer">
                                        <div class="form-group">
                                            <div class="select-wrapper">
                                                <label for="font-family-select">Font</label>
                                                <select class="select-inner" id="font-family-select">
                                                <option data-title="Inter" data-value="Inter" value="Font-Family" >Font-Family
                                                </option>
                                                <option data-title="Inter" data-value="Inter" value="Inter"  >Inter
                                                </option>
                                                <option data-title="Jost" data-value="Jost" value="Jost">Jost</option>
                                                <option data-title="DM Sans" data-value="DM Sans" value="DM Sans">DM sans
                                                </option>
                                                <option data-title="Mulish" data-value="Mulish" value="Mulish">Molish
                                                </option>
                                                <option data-title="Outfit" data-value="Outfit" value="Outfit">Outfit
                                                </option>
                                                <option data-title="Dancing Script" data-value="Dancing" value="Dancing Script">
                                                    Dancing</option>
                                                <option data-title="Playwrite US Trad"
                                                    data-value="Playwrite">Playwrite</option>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="select-wrapper">
                                                <label>Size</label>
                                                <select class="select-inner" id="font-size">
                                                <option data-title="Font-Size" data-value="Font-Size" value="Font-Size">
                                                    Font-Size</option>
                                                <option data-title="10px" data-value="10px">10px</option>
                                                <option data-title="16px" data-value="16px">16px</option>
                                                <option data-title="20px" data-value="20px">20px</option>
                                                <option data-title="24px" data-value="24px">24px</option>
                                                <option data-title="28px" data-value="28px">28px</option>
                                                <option data-title="34px" data-value="34px">34px</option>
                                                <option data-title="38px" data-value="38px">38px</option>
                                                <option data-title="42px" data-value="42px">42px</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="align-tab-pane" role="tabpanel" aria-labelledby="align-tab"
                                tabindex="0">
                                <div class="mobaile-form-text-edit">
                                    <div class="form-group-outer">
                                        <div class="form-group">
                                            <label>Style</label>
                                            <div class="text-style-btn-one">
                                                <a href="javascript:()" data-title="bold">
                                                    <i class="fa-solid fa-bold"></i>
                                                </a>
                                                <a href="javascript:()" data-title="italic">
                                                    <i class="icon-italic-font"></i>
                                                </a>
                                                <a href="javascript:()" data-title="underline">
                                                    <i class="icon-Underline"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="color-tab-pane" role="tabpanel" aria-labelledby="color-tab"
                                tabindex="0">
                                <div class="mobaile-form-text-edit">
                                    <div class="form-group-fluid">
                                        <div class="mobail-color-piker">
                                            <label>Color</label>
                                            <div class="color-target">
                                                <div class="inner-colum">
                                                    <input type="color" id="color-picker" class="color-target-inner"
                                                     value="#C95326">
                                                    <span class="color-target-code">#C95326</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="color-squr">
                                            <data value="#212528" style="background-color:#212528;"></data>
                                            <data value="#B93B33" style="background-color:#B93B33;"></data>
                                            <data value="#982E4F" style="background-color:#982E4F;"></data>
                                            <data value="#7C3396" style="background-color:#7C3396;"></data>
                                            <data value="#5B40BD" style="background-color:#5B40BD;"></data>
                                            <data value="#3B4EBE" style="background-color:#3B4EBE;"></data>
                                            <data value="#3163A7" style="background-color:#3163A7;"></data>
                                            <data value="#347183" style="background-color:#347183;"></data>
                                            <data value="#397E5D" style="background-color:#397E5D;"></data>
                                            <data value="#478847" style="background-color:#478847;"></data>
                                            <data value="#6A9330" style="background-color:#6A9330;"></data>
                                            <data value="#D87E32" style="background-color:#D87E32;"></data>
                                            <data value="#C95326" style="background-color:#C95326;"></data>
                                            <data value="#343A3F" style="background-color: #343A3F;"></data>
                                            <data value="#CF433C" style="background-color:#CF433C;"></data>
                                            <data value="#B1345C" style="background-color:#B1345C;"></data>
                                            <data value="#903DB0" style="background-color:#903DB0;"></data>
                                            <data value="#6244D2" style="background-color:#6244D2;"></data>
                                            <data value="#425AD4" style="background-color:#425AD4;"></data>
                                            <data value="#3370BB" style="background-color:#3370BB;"></data>
                                            <data value="#3D8296" style="background-color:#3D8296;"></data>
                                            <data value="#439269" style="background-color:#439269;"></data>
                                            <data value="#519E4D" style="background-color:#519E4D;"></data>
                                            <data value="#77A735" style="background-color:#77A735;"></data>
                                            <data value="#E19133" style="background-color:#E19133;"></data>
                                            <data value="#D8642B" style="background-color:#D8642B;"></data>
                                            <data value="#4A5055" style="background-color:#4A5055;"></data>
                                            <data value="#DC4F45" style="background-color:#DC4F45;"></data>
                                            <data value="#C5436D" style="background-color:#C5436D;"></data>
                                            <data value="#A147C2" style="background-color:#A147C2;"></data>
                                            <data value="#6A4BE0" style="background-color:#6A4BE0;"></data>
                                            <data value="#4961E2" style="background-color:#4961E2;"></data>
                                            <data value="#3F7CD2" style="background-color:#3F7CD2;"></data>
                                            <data value="#4496AB" style="background-color:#4496AB;"></data>
                                            <data value="#4CA57C" style="background-color:#4CA57C;"></data>
                                            <data value="#5DAF58" style="background-color:#5DAF58;"></data>
                                            <data value="#83B73D" style="background-color:#83B73D;"></data>
                                            <data value="#EAA538" style="background-color:#EAA538;"></data>
                                            <data value="#E7702D" style="background-color:#E7702D;"></data>
                                            <data value="#889096" style="background-color:#889096;"></data>
                                            <data value="#E75F59" style="background-color:#E75F59;"></data>
                                            <data value="#D55580" style="background-color:#D55580;"></data>
                                            <data value="#AE53D3" style="background-color:#AE53D3;"></data>
                                            <data value="#7553EA" style="background-color:#7553EA;"></data>
                                            <data value="#556DED" style="background-color:#556DED;"></data>
                                            <data value="#4589E0" style="background-color:#4589E0;"></data>
                                            <data value="#50A5BC" style="background-color:#50A5BC;"></data>
                                            <data value="#56B68A" style="background-color:#56B68A;"></data>
                                            <data value="#68BD63" style="background-color:#68BD63;"></data>
                                            <data value="#92C842" style="background-color:#92C842;"></data>
                                            <data value="#F1B440" style="background-color:#F1B440;"></data>
                                            <data value="#EC8737" style="background-color:#EC8737;"></data>
                                            <data value="#B1B7BE" style="background-color:#B1B7BE;"></data>
                                            <data value="#ED7570" style="background-color:#ED7570;"></data>
                                            <data value="#DD6E94" style="background-color:#DD6E94;"></data>
                                            <data value="#C064E3" style="background-color:#C064E3;"></data>
                                            <data value="#7F61F1" style="background-color:#7F61F1;"></data>
                                            <data value="#637BF0" style="background-color:#637BF0;"></data>
                                            <data value="#5399E8" style="background-color:#5399E8;"></data>
                                            <data value="#5BB5C8" style="background-color:#5BB5C8;"></data>
                                            <data value="#60C79B" style="background-color:#60C79B;"></data>
                                            <data value="#77CD72" style="background-color:#77CD72;"></data>
                                            <data value="#A3D74F" style="background-color:#A3D74F;"></data>
                                            <data value="#F6C649" style="background-color:#F6C649;"></data>
                                            <data value="#F19746" style="background-color:#F19746;"></data>
                                            <data value="#CFD5DA" style="background-color:#CFD5DA;"></data>
                                            <data value="#F08E8B" style="background-color:#F08E8B;"></data>
                                            <data value="#E689AB" style="background-color:#E689AB;"></data>
                                            <data value="#CD7BEB" style="background-color:#CD7BEB;"></data>
                                            <data value="#9277F2" style="background-color:#9277F2;"></data>
                                            <data value="#7A90F6" style="background-color:#7A90F6;"></data>
                                            <data value="#66AAF3" style="background-color:#66AAF3;"></data>
                                            <data value="#69C8D8" style="background-color:#69C8D8;"></data>
                                            <data value="#6FD7AD" style="background-color:#6FD7AD;"></data>
                                            <data value="#8AD986" style="background-color:#8AD986;"></data>
                                            <data value="#B3E363" style="background-color:#B3E363;"></data>
                                            <data value="#F9D65C" style="background-color:#F9D65C;"></data>
                                            <data value="#F3AD5E" style="background-color:#F3AD5E;"></data>
                                            <data value="#E0E4E7" style="background-color:#E0E4E7;"></data>
                                            <data value="#F4AEAC" style="background-color:#F4AEAC;"></data>
                                            <data value="#EDA7C1" style="background-color:#EDA7C1;"></data>
                                            <data value="#DC9CF4" style="background-color:#DC9CF4;"></data>
                                            <data value="#AE97F5" style="background-color:#AE97F5;"></data>
                                            <data value="#95A5F9" style="background-color:#95A5F9;"></data>
                                            <data value="#87BDF6" style="background-color:#87BDF6;"></data>
                                            <data value="#81D8E3" style="background-color:#81D8E3;"></data>
                                            <data value="#87E5C1" style="background-color:#87E5C1;"></data>
                                            <data value="#A4E8A3" style="background-color:#A4E8A3;"></data>
                                            <data value="#CAEA86" style="background-color:#CAEA86;"></data>
                                            <data value="#FDE27B" style="background-color:#FDE27B;"></data>
                                            <data value="#F5C583" style="background-color:#F5C583;"></data>
                                            <data value="#EBECF0" style="background-color:#EBECF0;"></data>
                                            <data value="#F7CCCA" style="background-color:#F7CCCA;"></data>
                                            <data value="#F2C4D6" style="background-color:#F2C4D6;"></data>
                                            <data value="#E6C0F6" style="background-color:#E6C0F6;"></data>
                                            <data value="#CEC0FB" style="background-color:#CEC0FB;"></data>
                                            <data value="#BCC9F9" style="background-color:#BCC9F9;"></data>
                                            <data value="#AED8FC" style="background-color:#AED8FC;"></data>
                                            <data value="#AAE8EE" style="background-color:#AAE8EE;"></data>
                                            <data value="#ACEFD9" style="background-color:#ACEFD9;"></data>
                                            <data value="#BEF1C0" style="background-color:#BEF1C0;"></data>
                                            <data value="#DFF4AB" style="background-color:#DFF4AB;"></data>
                                            <data value="#FCEDA2" style="background-color:#FCEDA2;"></data>
                                            <data value="#F8D9AD" style="background-color:#F8D9AD;"></data>
                                            <data value="#F1F3F4" style="background-color:#F1F3F4;"></data>
                                            <data value="#FBE5E3" style="background-color:#FBE5E3;"></data>
                                            <data value="#FAE0EB" style="background-color:#FAE0EB;"></data>
                                            <data value="#EEDBF8" style="background-color:#EEDBF8;"></data>
                                            <data value="#E2DDFC" style="background-color:#E2DDFC;"></data>
                                            <data value="#DDE5FC" style="background-color:#DDE5FC;"></data>
                                            <data value="#D7EAFF" style="background-color:#D7EAFF;"></data>
                                            <data value="#D2F5FB" style="background-color:#D2F5FB;"></data>
                                            <data value="#CEF7E9" style="background-color:#CEF7E9;"></data>
                                            <data value="#DBF8DC" style="background-color:#DBF8DC;"></data>
                                            <data value="#EBF9CE" style="background-color:#EBF9CE;"></data>
                                            <data value="#FEF3C5" style="background-color:#FEF3C5;"></data>
                                            <data value="#FBE9CF" style="background-color:#FBE9CF;"></data>
                                            <data value="#F8FAFB" style="background-color:#F8FAFB;"></data>
                                            <data value="#FFF6F7" style="background-color:#FFF6F7;"></data>
                                            <data value="#FDF0F5" style="background-color:#FDF0F5;"></data>
                                            <data value="#F7F0FB" style="background-color:#F7F0FB;"></data>
                                            <data value="#F2F0FE" style="background-color:#F2F0FE;"></data>
                                            <data value="#EDF2FE" style="background-color:#EDF2FE;"></data>
                                            <data value="#EBF5FF" style="background-color:#EBF5FF;"></data>
                                            <data value="#E9FBFE" style="background-color:#E9FBFE;"></data>
                                            <data value="#ECFDF7" style="background-color:#ECFDF7;"></data>
                                            <data value="#EEFBF2" style="background-color:#EEFBF2;"></data>
                                            <data value="#F3FEE4" style="background-color:#F3FEE4;"></data>
                                            <data value="#FDF9DD" style="background-color:#FDF9DD;"></data>
                                            <data value="#FDF3E6" style="background-color:#FDF3E6;"></data>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                    }else{ ?>
                    <div class="inner-container">
                        <div class="form-text-edit">
                            <form action="#">
                                <div class="form-group-fluid" style="display: none;">
                                    <label for="selectedtext">Text</label>
                                    <textarea rows="3" placeholder="Enter Your Text" id="myTextarea"></textarea>
                                </div>
                                <div class="form-group-outer">
                                    <div class="form-group">
                                        <div class="select-wrapper">
                                            <label for="font-family-select">Font</label>
                                            <select class="select-inner" id="font-family-select">
                                                <option data-title="Inter" data-value="Inter" value="Font-Family" >Font-Family
                                                </option>
                                                <option data-title="Inter" data-value="Inter" value="Inter"  >Inter
                                                </option>
                                                <option data-title="Jost" data-value="Jost" value="Jost">Jost</option>
                                                <option data-title="DM Sans" data-value="DM Sans" value="DM Sans">DM sans
                                                </option>
                                                <option data-title="Mulish" data-value="Mulish" value="Mulish">Molish
                                                </option>
                                                <option data-title="Outfit" data-value="Outfit" value="Outfit">Outfit
                                                </option>
                                                <option data-title="Dancing Script" data-value="Dancing" value="Dancing Script">
                                                    Dancing</option>
                                                <option data-title="Playwrite US Trad"
                                                    data-value="Playwrite">Playwrite</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="select-wrapper">
                                            <label>Size</label>
                                            <select class="select-inner" id="font-size">
                                                <option data-title="Font-Size" data-value="Font-Size" value="Font-Size">
                                                    Font-Size</option>
                                                <option data-title="10px" data-value="10px">10px</option>
                                                <option data-title="16px" data-value="16px">16px</option>
                                                <option data-title="20px" data-value="20px">20px</option>
                                                <option data-title="24px" data-value="24px">24px</option>
                                                <option data-title="28px" data-value="28px">28px</option>
                                                <option data-title="34px" data-value="34px">34px</option>
                                                <option data-title="38px" data-value="38px">38px</option>
                                                <option data-title="42px" data-value="42px">42px</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-outer">
                                </div>
                                <div class="form-group-outer">
                                    <div class="form-group">
                                        <div class="select-wrapper">
                                            <label>Style</label>
                                            <div class="text-style-btn-one">
                                                <a href="javascript:void(0);" data-title="bold">
                                                    <i class="fa-solid fa-bold"></i>
                                                </a>
                                                <a href="javascript:void(0);" data-title="italic">
                                                    <i class="icon-italic-font"></i>
                                                </a>
                                                <a href="javascript:void(0);" data-title="underline">
                                                    <i class="icon-Underline"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-fluid">
                                    <label>Color</label>
                                    <div class="color-target">
                                        <div class="inner-colum">
                                            <input type="color" id="color-picker" class="color-target-inner"
                                                value="#C95326">
                                            <span class="color-target-code">#C95326</span>
                                        </div>
                                    </div>
                                    <div class="color-squr">
                                        <data value="#212528" style="background-color:#212528;"></data>
                                        <data value="#B93B33" style="background-color:#B93B33;"></data>
                                        <data value="#982E4F" style="background-color:#982E4F;"></data>
                                        <data value="#7C3396" style="background-color:#7C3396;"></data>
                                        <data value="#5B40BD" style="background-color:#5B40BD;"></data>
                                        <data value="#3B4EBE" style="background-color:#3B4EBE;"></data>
                                        <data value="#3163A7" style="background-color:#3163A7;"></data>
                                        <data value="#347183" style="background-color:#347183;"></data>
                                        <data value="#397E5D" style="background-color:#397E5D;"></data>
                                        <data value="#478847" style="background-color:#478847;"></data>
                                        <data value="#6A9330" style="background-color:#6A9330;"></data>
                                        <data value="#D87E32" style="background-color:#D87E32;"></data>
                                        <data value="#C95326" style="background-color:#C95326;"></data>
                                        <data value="#343A3F" style="background-color: #343A3F;"></data>
                                        <data value="#CF433C" style="background-color:#CF433C;"></data>
                                        <data value="#B1345C" style="background-color:#B1345C;"></data>
                                        <data value="#903DB0" style="background-color:#903DB0;"></data>
                                        <data value="#6244D2" style="background-color:#6244D2;"></data>
                                        <data value="#425AD4" style="background-color:#425AD4;"></data>
                                        <data value="#3370BB" style="background-color:#3370BB;"></data>
                                        <data value="#3D8296" style="background-color:#3D8296;"></data>
                                        <data value="#439269" style="background-color:#439269;"></data>
                                        <data value="#519E4D" style="background-color:#519E4D;"></data>
                                        <data value="#77A735" style="background-color:#77A735;"></data>
                                        <data value="#E19133" style="background-color:#E19133;"></data>
                                        <data value="#D8642B" style="background-color:#D8642B;"></data>
                                        <data value="#4A5055" style="background-color:#4A5055;"></data>
                                        <data value="#DC4F45" style="background-color:#DC4F45;"></data>
                                        <data value="#C5436D" style="background-color:#C5436D;"></data>
                                        <data value="#A147C2" style="background-color:#A147C2;"></data>
                                        <data value="#6A4BE0" style="background-color:#6A4BE0;"></data>
                                        <data value="#4961E2" style="background-color:#4961E2;"></data>
                                        <data value="#3F7CD2" style="background-color:#3F7CD2;"></data>
                                        <data value="#4496AB" style="background-color:#4496AB;"></data>
                                        <data value="#4CA57C" style="background-color:#4CA57C;"></data>
                                        <data value="#5DAF58" style="background-color:#5DAF58;"></data>
                                        <data value="#83B73D" style="background-color:#83B73D;"></data>
                                        <data value="#EAA538" style="background-color:#EAA538;"></data>
                                        <data value="#E7702D" style="background-color:#E7702D;"></data>
                                        <data value="#889096" style="background-color:#889096;"></data>
                                        <data value="#E75F59" style="background-color:#E75F59;"></data>
                                        <data value="#D55580" style="background-color:#D55580;"></data>
                                        <data value="#AE53D3" style="background-color:#AE53D3;"></data>
                                        <data value="#7553EA" style="background-color:#7553EA;"></data>
                                        <data value="#556DED" style="background-color:#556DED;"></data>
                                        <data value="#4589E0" style="background-color:#4589E0;"></data>
                                        <data value="#50A5BC" style="background-color:#50A5BC;"></data>
                                        <data value="#56B68A" style="background-color:#56B68A;"></data>
                                        <data value="#68BD63" style="background-color:#68BD63;"></data>
                                        <data value="#92C842" style="background-color:#92C842;"></data>
                                        <data value="#F1B440" style="background-color:#F1B440;"></data>
                                        <data value="#EC8737" style="background-color:#EC8737;"></data>
                                        <data value="#B1B7BE" style="background-color:#B1B7BE;"></data>
                                        <data value="#ED7570" style="background-color:#ED7570;"></data>
                                        <data value="#DD6E94" style="background-color:#DD6E94;"></data>
                                        <data value="#C064E3" style="background-color:#C064E3;"></data>
                                        <data value="#7F61F1" style="background-color:#7F61F1;"></data>
                                        <data value="#637BF0" style="background-color:#637BF0;"></data>
                                        <data value="#5399E8" style="background-color:#5399E8;"></data>
                                        <data value="#5BB5C8" style="background-color:#5BB5C8;"></data>
                                        <data value="#60C79B" style="background-color:#60C79B;"></data>
                                        <data value="#77CD72" style="background-color:#77CD72;"></data>
                                        <data value="#A3D74F" style="background-color:#A3D74F;"></data>
                                        <data value="#F6C649" style="background-color:#F6C649;"></data>
                                        <data value="#F19746" style="background-color:#F19746;"></data>
                                        <data value="#CFD5DA" style="background-color:#CFD5DA;"></data>
                                        <data value="#F08E8B" style="background-color:#F08E8B;"></data>
                                        <data value="#E689AB" style="background-color:#E689AB;"></data>
                                        <data value="#CD7BEB" style="background-color:#CD7BEB;"></data>
                                        <data value="#9277F2" style="background-color:#9277F2;"></data>
                                        <data value="#7A90F6" style="background-color:#7A90F6;"></data>
                                        <data value="#66AAF3" style="background-color:#66AAF3;"></data>
                                        <data value="#69C8D8" style="background-color:#69C8D8;"></data>
                                        <data value="#6FD7AD" style="background-color:#6FD7AD;"></data>
                                        <data value="#8AD986" style="background-color:#8AD986;"></data>
                                        <data value="#B3E363" style="background-color:#B3E363;"></data>
                                        <data value="#F9D65C" style="background-color:#F9D65C;"></data>
                                        <data value="#F3AD5E" style="background-color:#F3AD5E;"></data>
                                        <data value="#E0E4E7" style="background-color:#E0E4E7;"></data>
                                        <data value="#F4AEAC" style="background-color:#F4AEAC;"></data>
                                        <data value="#EDA7C1" style="background-color:#EDA7C1;"></data>
                                        <data value="#DC9CF4" style="background-color:#DC9CF4;"></data>
                                        <data value="#AE97F5" style="background-color:#AE97F5;"></data>
                                        <data value="#95A5F9" style="background-color:#95A5F9;"></data>
                                        <data value="#87BDF6" style="background-color:#87BDF6;"></data>
                                        <data value="#81D8E3" style="background-color:#81D8E3;"></data>
                                        <data value="#87E5C1" style="background-color:#87E5C1;"></data>
                                        <data value="#A4E8A3" style="background-color:#A4E8A3;"></data>
                                        <data value="#CAEA86" style="background-color:#CAEA86;"></data>
                                        <data value="#FDE27B" style="background-color:#FDE27B;"></data>
                                        <data value="#F5C583" style="background-color:#F5C583;"></data>
                                        <data value="#EBECF0" style="background-color:#EBECF0;"></data>
                                        <data value="#F7CCCA" style="background-color:#F7CCCA;"></data>
                                        <data value="#F2C4D6" style="background-color:#F2C4D6;"></data>
                                        <data value="#E6C0F6" style="background-color:#E6C0F6;"></data>
                                        <data value="#CEC0FB" style="background-color:#CEC0FB;"></data>
                                        <data value="#BCC9F9" style="background-color:#BCC9F9;"></data>
                                        <data value="#AED8FC" style="background-color:#AED8FC;"></data>
                                        <data value="#AAE8EE" style="background-color:#AAE8EE;"></data>
                                        <data value="#ACEFD9" style="background-color:#ACEFD9;"></data>
                                        <data value="#BEF1C0" style="background-color:#BEF1C0;"></data>
                                        <data value="#DFF4AB" style="background-color:#DFF4AB;"></data>
                                        <data value="#FCEDA2" style="background-color:#FCEDA2;"></data>
                                        <data value="#F8D9AD" style="background-color:#F8D9AD;"></data>
                                        <data value="#F1F3F4" style="background-color:#F1F3F4;"></data>
                                        <data value="#FBE5E3" style="background-color:#FBE5E3;"></data>
                                        <data value="#FAE0EB" style="background-color:#FAE0EB;"></data>
                                        <data value="#EEDBF8" style="background-color:#EEDBF8;"></data>
                                        <data value="#E2DDFC" style="background-color:#E2DDFC;"></data>
                                        <data value="#DDE5FC" style="background-color:#DDE5FC;"></data>
                                        <data value="#D7EAFF" style="background-color:#D7EAFF;"></data>
                                        <data value="#D2F5FB" style="background-color:#D2F5FB;"></data>
                                        <data value="#CEF7E9" style="background-color:#CEF7E9;"></data>
                                        <data value="#DBF8DC" style="background-color:#DBF8DC;"></data>
                                        <data value="#EBF9CE" style="background-color:#EBF9CE;"></data>
                                        <data value="#FEF3C5" style="background-color:#FEF3C5;"></data>
                                        <data value="#FBE9CF" style="background-color:#FBE9CF;"></data>
                                        <data value="#F8FAFB" style="background-color:#F8FAFB;"></data>
                                        <data value="#FFF6F7" style="background-color:#FFF6F7;"></data>
                                        <data value="#FDF0F5" style="background-color:#FDF0F5;"></data>
                                        <data value="#F7F0FB" style="background-color:#F7F0FB;"></data>
                                        <data value="#F2F0FE" style="background-color:#F2F0FE;"></data>
                                        <data value="#EDF2FE" style="background-color:#EDF2FE;"></data>
                                        <data value="#EBF5FF" style="background-color:#EBF5FF;"></data>
                                        <data value="#E9FBFE" style="background-color:#E9FBFE;"></data>
                                        <data value="#ECFDF7" style="background-color:#ECFDF7;"></data>
                                        <data value="#EEFBF2" style="background-color:#EEFBF2;"></data>
                                        <data value="#F3FEE4" style="background-color:#F3FEE4;"></data>
                                        <data value="#FDF9DD" style="background-color:#FDF9DD;"></data>
                                        <data value="#FDF3E6" style="background-color:#FDF3E6;"></data>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="tab-pane fade" id="v-pills-background" role="tabpanel"
                    aria-labelledby="v-pills-background-tab" tabindex="0">
                    <?php 
                    if(wp_is_mobile())
                    {    
                    ?>
                    <div class="mobail-tab">
                        <ul class="nav nav-tabs" id="mobaile-Tab-one" role="tablist">
                            <li class="nav-item " role="presentation">
                                <button class="nav-link active" id="patterns-tab" data-bs-toggle="tab"
                                    data-bs-target="#patterns-tab-pane" type="button" role="tab"
                                    aria-controls="patterns-tab-pane" aria-selected="true">Patterns</button>
                            </li>
                            <li>
                                <button class="cloes-btn">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="mobaile-tabcontent-one">
                            <div class="tab-pane fade show active" id="patterns-tab-pane" role="tabpanel"
                                aria-labelledby="patterns-tab" tabindex="0">
                                <div class="mobaile-form-text-edit">
                                    <div class="background-images-piker">
                                        <div class="inner-container">
                                            <div class="bg-img-iteam active">
                                                <img src="<?php echo get_template_directory_uri();?>/assets/img/preview-bg.jpg" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                    }else{ ?>
                    <div class="inner-container">
                        <div class="form-text-edit">
                            <form action="#">
                                <div class="background-images-edit active">
                                    <span class="hedding">Patterns</span>
                                    <span class="background-slidedown-icon">
                                        <i class="icon-chevron-down"></i>
                                    </span>
                                </div>
                                <div class="background-images-piker">
                                    <div class="inner-container">
                                        <div class="bg-img-inner">
                                            <div class="bg-img-iteam active">
                                            <?php echo '<img id="img1" src="' . get_template_directory_uri() . '/assets/img/preview-bg.jpg" alt="">' ?>
                                            </div>
                                        </div>    
                                        <div class="bg-img-inner">
                                            <div class="bg-img-iteam">
                                            <?php echo '<img id="img2" src="' . get_template_directory_uri() . '/assets/img/preview-bg2.jpg" alt="">' ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="wl-right-slide-bar">
    <?php
    echo get_template_part('template-parts/dashboard/menu');
    ?>
    </div>    
<?php
$currentURL = site_url();
$dashQuery = 'user-dashboard';
$dashback = '/?dashboard=details';
$dashpreview = '/?dashboard=preview';
// Determine the correct permalink structure
global $wp_rewrite;
if ($wp_rewrite->permalink_structure == '') {
    $perma = "&";
} else {
    $perma = "/";
}
$current_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// Parse the query string from the URL
$query_string = parse_url($current_url, PHP_URL_QUERY);
// Parse the query string into an associative array
parse_str($query_string, $params);
// Get the values of the 'card_id' and 'event_id' parameters
$card_id = isset($params['card_id']) ? intval($params['card_id']) : null;
$event_id = isset($params['event_id']) ? intval($params['event_id']) : null;
$card_post = get_post($card_id);
$previewURL = esc_url($currentURL . $perma . $dashQuery . $dashpreview);
$detailsURL = esc_url($currentURL . $perma . $dashQuery . $dashback . '&card_id='. $card_id . '&event_id='. $event_id); 
global $wpdb;
$sanas_card_event_table = $wpdb->prefix . 'sanas_card_event';
$rsvppagequery = $wpdb->prepare(
"SELECT event_rsvp_id 
    FROM $sanas_card_event_table 
        WHERE event_card_id = %d 
        AND event_no = %d",
    $card_id,
    $event_id
);
// Execute the query and get the result
$rsvpId = $wpdb->get_var($rsvppagequery); 
$existing_rsvp_query = new WP_Query(array(
    'post_type' => 'sanas_rsvp',
    'author' => $user_id,
    'posts_per_page' => 1,  // Limit to 1 post per user
));
if ($rsvpId!=0) {
    // If an existing RSVP post is found
    $existing_rsvp_query->the_post();
    $edit_id = $rsvpId;
    $rsvpvideo = esc_html(get_post_meta($edit_id, 'opt_upload_video', true));
    $guestName = esc_html(get_post_meta($edit_id, 'guest_name', true));
    $eventtitle = esc_html(get_post_meta($edit_id, 'event_name', true));
    $eventdate = esc_html(get_post_meta($edit_id, 'event_date', true));
    $guestContact = esc_html(get_post_meta($edit_id, 'guest_contact', true));
    $guestMessage = esc_html(get_post_meta($edit_id, 'guest_message', true));
    $program = get_post_meta($edit_id, 'listing_itinerary_details', true);
    $registry = get_post_meta($edit_id, 'registries', true);

    $itinerary = get_post_meta($edit_id, 'itinerary', true);


    $guest_name_css = get_post_meta($edit_id, 'guest_name_css', true);
    $guest_contact_css = get_post_meta($edit_id, 'guest_contact_css', true);
    $guest_message_css = get_post_meta($edit_id, 'guest_message_css', true);
    $event_title_css = get_post_meta($edit_id, 'event_title_css', true);
    $event_date_css = get_post_meta($edit_id, 'event_date_css', true);

    $itinerary_css = get_post_meta($edit_id, 'itinerarycss', true);

    wp_reset_postdata();
    
} 
else {
    // If no existing RSVP post is found, initialize variables to empty or default values
    $edit_id = '0';
    $rsvpvideo = '';
    $guestName = '';
    $eventtitle = '';
    $eventdate = '';
    $guestContact = '';
    $guestMessage = "";
    $program = array();
    $registry = array();

    $itinerary = '';


    $guest_name_css = '';
    $guest_contact_css = '';
    $guest_message_css = '';
    $event_title_css = '';
    $event_date_css = '';
    $itinerary_css = '';

}                  
function sanas_is_youtube_url($url) {
            return preg_match('/^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/', $url);
}    
 $rsvpimagequery = $wpdb->prepare(
      "SELECT event_rsvp_bg_link FROM $sanas_card_event_table WHERE event_no = %d",
       $event_id
 );                           
$rsvpimage = $wpdb->get_var($rsvpimagequery);
$default_image_url = get_template_directory_uri() . '/assets/img/preview-bg.jpg';

// Use the default image if the database image is empty
if (empty($rsvpimage)) {
    $rsvpimage = $default_image_url;
}
?>
<style type="text/css">
#canvasElement {
    background-image: url('<?php echo $rsvpimage ?>') ;
    background-size: cover; 
    background-position: center; 
    background-repeat: no-repeat; 
}
</style>
    <section class="wl-main-canvas rsvp">
        <div class="container-fluid">
            <div class="inner-colum" id="canvasElement">
                <div class="content content-3">
                    <?php if ($imageEnable && !empty($rsvpImage)) {?>
                    <div class="divider">
                        <h5 class="m-0 mb-2">Upload Your Pre-Event Shoot or Video Invitation Here...</h5>
                        <img src="<?php echo esc_url($rsvpImage['url']) ?>" alt="rsvp-image">
                    </div>
                    <?php } ?>
                    <form method="post" id="add-rsvp" enctype="multipart/form-data">
                    <div class="wl-card-detaile">
                        <div class="row">
                            <div class="col-xxl-9 col-xl-10 col-lg-10 col-md-12 m-auto">
                                <?php if(empty($rsvpvideo)){ ?>
                                 <div class="video-box" id="drop-zone">
                                 <video id="uploaded-video" controls style="display:none;"></video> 
                                 <div class="delete-btn" style="display:none;">
                                    <button class="deleteRowBtn"><i class="fa-regular fa-trash-can"></i></button>
                                </div>
                                <div class="video-inner-box">
                                    <div class="col-xxl-4 col-xl-5 col-lg-7 col-md-8 col-sm-12 m-auto">
                                        <div class="form-field video-upload">
                                            <label>Video link</label>
                                            <div class="video-file-upload">
                                                <a href="#" id="upload-link" class="icon">
                                                    <i class="icon-Upload-2"></i>
                                                </a>
                                                <span>
                                                        <label for="video-upload" id="upload-link" class="icon">
                                                            <?php echo esc_html('Click to upload') ?>
                                                        </label>
                                                        <input type="file" id="video-upload" accept="video/*" style="display: none;">
                                                 </span>
                                                <span class="note">Max. size 50MB</span>
                                            </div>
                                            <span>Or</span>
                                            <input type="text" id="youtube-url" placeholder="Enter YouTube URL" size="50">
                                            <button id="generate-youtube-video" class="btn btn-primary">Generate YouTube Video</button>
                                            <div id="drop-zone"></div>
                                        </div>
                                    </div>
                                  </div>   
                                </div>
                                <?php }else{ ?>

                                            <?php if (sanas_is_youtube_url($rsvpvideo)) : ?>
                                                <?php
                                                $youtubevideo = $rsvpvideo;
                                                // Extract YouTube video ID
                                                preg_match('/\/([^\/]+)$/', $youtubevideo, $matches);
                                                $youtube_id = $matches[1];
                                                ?>
                                                <div class="youtube-container">
                                                    <iframe id="youtube-iframe" width="1000" height="490" src="https://www.youtube.com/embed/<?php echo esc_attr($youtube_id); ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                    <div class="delete-btn">
                                                        <button class="deleteRowBtn"><i class="fa-regular fa-trash-can"></i></button>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <?php if (!empty($rsvpvideo)) { ?>
                                                    <div class="video-container">
                                                        <video controls>
                                                            <source src="<?php echo esc_url($rsvpvideo); ?>">
                                                        </video>
                                                        <div class="delete-btn">
                                                            <button class="deleteRowBtn"><i class="fa-regular fa-trash-can"></i></button>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            <?php endif; ?>
                                                <div class="video-box" id="drop-zone" style="display:none">
                                                    <video id="uploaded-video" controls style="display:none;"></video>
                                                    <div class="delete-btn" style="display:none;">
                                                        <button class="deleteRowBtn"><i class="fa-regular fa-trash-can"></i></button>
                                                    </div>
                                                    <div class="video-inner-box">
                                                        <div class="col-xxl-4 col-xl-5 col-lg-7 col-md-8 col-sm-12 m-auto video-inner-box">
                                                            <div class="form-field">
                                                                <div class="video-file-upload">
                                                                    <a href="#" id="upload-link" class="icon">
                                                                          <i class="icon-Upload-2"></i>
                                                                    </a>
                                                                    <label for="video-upload" id="upload-link" class="icon">
                                                                        <?php echo esc_html('Click to upload') ?>
                                                                    </label>
                                                                    <input type="file" id="video-upload" accept="video/*" style="display: none;">
                                                                    <span class="note">Max. size 50MB</span>
                                                                </div>
                                                                <input type="text" id="youtube-url" placeholder="Enter YouTube URL" size="50">
                                                                <button id="generate-youtube-video" class="btn btn-primary">Generate YouTube Video</button>
                                                                <div id="drop-zone"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                    <?php } ?>

                            </div>
                        </div>
                    <?php if ($imageEnable && !empty($rsvpImage)) {?>
                    <div class="divider">
                        <img src="<?php echo esc_url($rsvpImage['url']) ?>" alt="rsvp-image">
                    </div>
                    <?php } ?>
                            <div class="row">
                            <div class="rsvp-from-group">
                                <input type="text edit-text rsvp-msg event-title" id="eventtitle" class="edit-text rsvp-msg event-title" name="eventtitle" placeholder="Event Title*" style="<?php echo $event_title_css; ?>" value="<?php echo esc_html($eventtitle) ?>" required="">
                                </div>
                                <div class="rsvp-from-group">
                                    <input type="date" id="eventdate" class="edit-text rsvp-msg event-date" name="eventdate"  style="<?php echo $event_date_css; ?>" value="<?php echo esc_html($eventdate); ?>" required="">
                                </div>
                                <div class="rsvp-from-group">
                                    <h4 class="mb-0">Hosted By</h4>
                                    <input type="text" id="guestName" name="guestName" value="<?php echo esc_html($guestName) ?>" style="<?php echo $guest_name_css; ?>"  class="edit-text rsvp-msg host-name"  placeholder="Event Host Name*" required="">
                                </div>
                                <div class="rsvp-from-group">
                                    <input type="number" id="guestContact" style="<?php echo $guest_contact_css; ?>" value="<?php echo esc_html($guestContact); ?>" class="edit-text rsvp-msg host-contact-no" name="guestContact"  placeholder="Enter Host Contact No.*" required="">
                                </div>
                                <div class="rsvp-from-group mt-3 mb-2 map-container-rsvp">
                                    <h4>Address</h4>
                                        <input class="map-input-rsvp" id="search" type="text" placeholder="Search location">
                                        <div class="map-location-rsvp" id="map"></div>
                                </div>
                                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2TZGxSFxPToAsFcoE7I1fdENSJuK_Eic&libraries=places" async defer></script>
                                    <script>
                                        let map;
                                        let marker;

                                        function initializeAutocomplete() {
                                            const input = document.getElementById("search");

                                            // Initialize map centered at a default location
                                            map = new google.maps.Map(document.getElementById("map"), {
                                                center: { lat: 20.5937, lng: 78.9629 }, // Default: India
                                                zoom: 5,
                                            });

                                            // Initialize marker, hidden by default
                                            marker = new google.maps.Marker({
                                                map: map,
                                                visible: false,
                                            });

                                            // Ensure the Google Places API is loaded before initializing autocomplete
                                            if (typeof google === "undefined" || !google.maps.places) {
                                                console.error("Google Maps API failed to load.");
                                                return;
                                            }

                                            // Create the autocomplete object
                                            const autocomplete = new google.maps.places.Autocomplete(input);

                                            // Add a listener for when a place is selected
                                            autocomplete.addListener('place_changed', function () {
                                                const place = autocomplete.getPlace();

                                                if (place.geometry) {
                                                    // Get coordinates
                                                    const location = place.geometry.location;
                                                    const lat = location.lat();
                                                    const lng = location.lng();

                                                    // Update map and marker
                                                    map.setCenter(location);
                                                    map.setZoom(15);
                                                    marker.setPosition(location);
                                                    marker.setVisible(true);
                                                    
                                                    // Generate Google Maps link with location name and address
                                                    const googleMapLink = `https://www.google.com/maps?q=${encodeURIComponent(place.name)}%20${encodeURIComponent(place.formatted_address)}`;
                                                    console.log("Google Maps Link:", googleMapLink);

                                                    // Log details to the console
                                                    console.log("Selected Location:", place.name);
                                                    console.log("Formatted Address:", place.formatted_address);
                                                    console.log("Coordinates:", { lat, lng });
                                                } else {
                                                    console.log("No details available for the input: '" + place.name + "'");
                                                }
                                            });
                                        }

                                        // Initialize Autocomplete after the API script is loaded
                                        window.addEventListener('load', initializeAutocomplete);
                                    </script>
                                <div class="rsvp-from-group">
                                    <textarea class="edit-text rsvp-msg host-message" style="<?php echo $guest_message_css; ?>" id="guestMessage" name="guestMessage"
                                        placeholder="Special Instructions, Dress Code, etc..."><?php echo esc_html($guestMessage); ?></textarea>
                                    </div>
                                    <div class="rsvp-from-group">
                                        <h4 class=" mb-0">Itinerary</h4>
                                    </div>
                                </div>
                            <?php wp_nonce_field('ajax-sanas-rsvp-nonce', 'sanasrsvpsecurity');?>
                        </form>
                        <div class="row">
                            <div class="col-xxl-4 col-xl-5 col-lg-7 col-md-8 col-sm-12 m-auto">
                                <div class="wl-fuc-timing form-field">
                                   <div class="rsvp-event">
                                     <table id="program-time">
                                        <tbody>
                                                <?php 
                                            if( !empty($program) && count($program)>0 ){
                                            foreach ($program as $event) :?>
                                            <tr>
                                              <td class="edit-text" contenteditable="true"><?php echo esc_attr($event['program_name'])?></td>
                                              <td class="edit-text" contenteditable="true"><?php echo esc_attr($event['program_time'])?></td>
                                              <td>
                                                <button class="deleteRowBtn"><i class="fa-regular fa-trash-can"></i></button>
                                             </td>
                                             </tr>
                                    <?php endforeach; }
                                    else{ 
                                        if ($rsvpId==0) {
                                        ?>
                                          <tr>
                                              <td class="edit-text" contenteditable="true">Evening</td>
                                              <td class="edit-text text-start" contenteditable="true">7:00 PM</td>
                                              <td>
                                                <button class="deleteRowBtn"><i class="fa-regular fa-trash-can"></i></button>
                                             </td>
                                             </tr>
                                   <?php }
                                    }
                                    ?>
                                    </tbody>
                                    </table>                                    
                                    <button id="add-event-btn" class="add-form-one"><i class="icon-plus"></i>Add
                                    </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <form method="post" id="add-registry" enctype="multipart/form-data">
            <input type="hidden" name="rsvp_id" value="<?php echo esc_attr($edit_id); ?>">
            <div class="registry">
                <div class="container">
                    <div class="row">
                        <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-8 col-sm-12 m-auto">
                            <div class="form-field" id="program-time1">
                                <h4>Registry</h4>
                                <?php
                                    if (!empty($registry) && count($registry) > 0) {

                                        $i=1;
                                        foreach ($registry as $event) : 

                                            ?>
                                    <div class="gift-registry-input" id="gift_<?php echo esc_attr($i); ?>">
                                        <div class="delete-btn">
                                            <button class="deleteRowBtn"><i class="fa-regular fa-trash-can"></i></button>
                                        </div>
                                        <input type="text" value="<?php echo esc_attr($event['name']); ?>" placeholder="Company Name">
                                        <input type="url" value="<?php echo esc_attr($event['url']); ?>" placeholder="Enter URL">
                                    </div>
                                <?php 
                                    $i=$i+1;
                                endforeach; 
                                    } ?>                                
                                <div class="gift-registry-input">
                                    <div class="delete-btn">
                                        <button class="deleteRowBtn"><i class="fa-regular fa-trash-can"></i></button>
                                    </div>
                                    <input type="text" placeholder="Company Name">
                                    <input type="url" placeholder="Enter URL">
                                </div>
                                <button class="btn btn-secondary btn-block add-gift">Add More </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-4">
                                <button id="back-page-redirect" class="btn btn-secondary" 
                                event-id="<?php echo esc_attr($event_id); ?>" 
                                rsvp-id="<?php echo esc_attr($rsvpId); ?>"
                                card-id="<?php echo esc_attr($card_id); ?>"
                                 btn-url="<?php echo esc_url($detailsURL); ?>"><i class="fa-solid fa-arrow-left" ></i> Back</button>

                                <button id="save-rsvp-data" class="btn btn-secondary" event-id="<?php echo esc_attr($event_id); ?>" rsvp-id="<?php echo esc_attr($rsvpId); ?>" card-id="<?php echo esc_attr($card_id); ?>" btn-url="<?php echo esc_url($previewURL); ?>">Next <i class="fa-solid fa-arrow-right"></i></button>
                                <?php wp_nonce_field('ajax-sanas-save-rsvp-nonce', 'sanassaversvpsecurity'); ?>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
            <?php wp_nonce_field('ajax-sanas-registry-nonce', 'sanasregistrysecurity'); ?>
           </form>
        </div>
    </section>
<input type="hidden" name="header-options-msg" id="header-options-msg" value="You will lose your invitation progress.RSVP of your card step."/>
