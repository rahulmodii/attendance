<div>
    <div class="card mb-5 mb-xl-10">
        <!--begin::Body-->
        <div class="card-body py-10">
            <h2 class="mb-9">White Label Program</h2>
            <!--begin::Overview-->
            <div class="row mb-10">
                <!--begin::Col-->
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-xl-12">
                    <h4 class="text-gray-800 mb-0">Domain</h4>
                    <p class="fs-6 fw-semibold text-gray-600 py-4 m-0">Add your A record in domain
                    <br>@104.237.9.112</p>
                    <div class="d-flex">
                        <input  wire:model='domain' type="text" class="form-control form-control-solid me-3 flex-grow-1" >
                        <button  class="btn btn-primary btn-active-light-primary fw-bold flex-shrink-0" wire:click='saveDomain'>Save</button>
                    </div>
                </div>
                <div class="col-xl-12 mt-10">
                    <h4 class="text-gray-800 mb-0">Webhook</h4>
                    <p class="fs-6 fw-semibold text-gray-600 py-4 m-0">Plan your blog post by choosing a topic, creating an outline conduct
                    <br>research, and checking facts</p>
                    <div class="d-flex">
                        <input wire:model='webhook'  type="text" class="form-control form-control-solid me-3 flex-grow-1">
                        <button  class="btn btn-primary btn-active-light-primary fw-bold flex-shrink-0" wire:click='saveWebhook'>Save</button>
                    </div>
                </div>
                <!--end::Col-->
            </div>

        </div>

        <div class="card-body py-10">
            <h2 class="mb-9">White Label Config</h2>
            <!--begin::Overview-->
            <div class="row mb-10">
                <div class="col-xl-12 mt-10">
                    <h4 class="text-gray-800 mb-0">Logo</h4>
                    <p class="fs-6 fw-semibold text-gray-600 py-4 m-0">Please convert png to ico and upload logo
                    <br>https://www.freeconvert.com/png-to-ico</p>
                    <div class="d-flex">
                        <input wire:model='logo' type="file"  type="text" class="form-control form-control-solid me-3 flex-grow-1">
                        {{-- <button  class="btn btn-primary btn-active-light-primary fw-bold flex-shrink-0" wire:click='saveWebhook'>Save</button> --}}
                    </div>
                </div>
                <div class="col-xl-12 mt-10">
                    <h4 class="text-gray-800 mb-0">Software name</h4>

                    <div class="d-flex">
                        <input wire:model='software_name' type="text"  type="text" class="form-control form-control-solid me-3 flex-grow-1">
                        {{-- <button  class="btn btn-primary btn-active-light-primary fw-bold flex-shrink-0" wire:click='saveWebhook'>Save</button> --}}
                    </div>
                </div>


                <div class="col-xl-12 mt-10">
                    <h4 class="text-gray-800 mb-0">Support number</h4>
                    <div class="d-flex">
                        <input wire:model='support_number' type="text"  type="text" class="form-control form-control-solid me-3 flex-grow-1">
                        <button  class="btn btn-primary btn-active-light-primary fw-bold flex-shrink-0" wire:click='save'>Save</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
