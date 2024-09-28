

<div id="layout-wrapper">
            
            @include('layouts.includes.top_bar')
            <!-- ========== Left Sidebar Start ========== -->
            @include('layouts.includes.vertical_bar')
            <!-- Left Sidebar End -->

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            

        

    <!-- <========================= Content Here=======================================================> -->
    <div class="wrapper">
        <div class="row">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <small><a class="nav-link active" data-bs-toggle="tab" href="#tab1" role="tab">MONTHLY PAYMENTS</a></small> 
                </li>
                <li class="nav-item">
                    <small><a class="nav-link" data-bs-toggle="tab" href="#tab2" role="tab">DOCUMENTS CENTRE</a></small>   
                </li>
                <li class="nav-item">
                    <small><a class="nav-link" data-bs-toggle="tab" href="#tab3" role="tab">WORKFLOW HISTORY</a></small>
                </li>
                <li class="nav-item">
                    <small><a class="nav-link" data-bs-toggle="tab" href="#tab4" role="tab">NON-PAID & PAID MEMBERS</a></small>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div id="tab1" class="container tab-pane active" role="tabpanel"><br>
                    @include('contributions.includes.month_payment')
                 </div>
                <div id="tab2" class="container tab-pane fade" role="tabpanel">
                    <br>
                    @include('contributions.includes.document_centre')
                </div>
                </div>

                
                <div id="tab3" class="container tab-pane fade" role="tabpanel"><br>
                    <h3>Tab 3</h3>
                    <p>Content for Tab 3.</p>
                </div>
                <div id="tab4" class="container tab-pane fade" role="tabpanel"><br>
                    @include('contributions.includes.non_paid_members')
                </div>
            </div>
        </div>
    </div>
</div>

