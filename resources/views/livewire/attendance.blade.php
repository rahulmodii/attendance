<div>
    <div class="row gx-5 g-xl-10 g-xl-10">
        <div class="col-xl-12 mb-xl-10">
            <!--begin::Engage widget 3-->
            <div class="card bg-primary h-md-100" data-bs-theme="light">
                <!--begin::Body-->
                <div class="card-body d-flex flex-column pt-13 pb-14">
                    <!--begin::Heading-->
                    <div class="m-0">
                        <!--begin::Title-->
                        <h1 class="fw-semibold text-white text-center lh-lg mb-9">Easy
                            Attendance
                            <br>
                            <span class="fw-bolder">Start Your Delivery</span>
                        </h1>
                        <!--end::Title-->
                        <!--begin::Illustration-->
                        <div class="flex-grow-1 bgi-no-repeat bgi-size-contain bgi-position-x-center card-rounded-bottom h-200px mh-200px my-5 mb-lg-12"
                            style="background-image:url('assets/media/svg/illustrations/easy/5.svg')">
                        </div>
                        <!--end::Illustration-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Links-->

                    <div class="text-center" id="canvasVideo" style="display: none">
                        <video id="webcam" autoplay playsinline width="100%" height="300"></video>
                        <canvas id="canvas" class="d-none"></canvas>
                        <audio id="snapSound" src="audio/snap.wav" preload = "auto"></audio>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-sm bg-white btn-color-gray-800 me-2"
                            @if ($isDisable) disabled @endif onclick="captureCamera()">Check
                            In</button>

                        <button class="btn btn-sm bg-white btn-color-gray-800 me-2"
                            @if ($isDisable) disabled @endif onclick='captureCameraCheckout()'>Check
                            Out</button>
                    </div>
                    @if ($isDisable)
                        <div class="text-center mt-10">
                            <span style="color: white">
                                Please Move inside office and refresh page
                            </span>
                        </div>
                    @endif

                    <!--end::Links-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Engage widget 3-->
        </div>
    </div>
    <div class="card card-flush mb-5 mb-xl-10">
        <div class="card-header pt-7">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold text-gray-900">Attendance Report</span>
                {{-- <span class="text-gray-500 mt-1 fw-semibold fs-6">{{ $latitude }} {{ $longitude }}</span> --}}
            </h3>
            <div class="card-toolbar">
                <div class="d-flex flex-stack flex-wrap gap-4">
                    <div class="d-flex align-items-center fw-bold">
                        <div class="text-muted fs-7 me-2">Cateogry</div>
                        <select
                            class="form-select form-select-transparent text-gray-900 fs-7 lh-1 fw-bold py-0 ps-3 w-auto"
                            data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px"
                            data-placeholder="Select an option">
                            <option></option>
                            <option value="Show All" selected="selected">Show All
                            </option>
                            <option value="a">Category A</option>
                            <option value="b">Category B</option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center fw-bold">
                        <div class="text-muted fs-7 me-2">Status</div>
                        <select
                            class="form-select form-select-transparent text-gray-900 fs-7 lh-1 fw-bold py-0 ps-3 w-auto"
                            data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px"
                            data-placeholder="Select an option" data-kt-table-widget-5="filter_status">
                            <option></option>
                            <option value="Show All" selected="selected">Show All
                            </option>
                            <option value="In Stock">In Stock</option>
                            <option value="Out of Stock">Out of Stock</option>
                            <option value="Low Stock">Low Stock</option>
                        </select>
                    </div>
                    {{-- <a href="apps/ecommerce/catalog/products.html" class="btn btn-light btn-sm">View Stock</a> --}}
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table align-middle table-row-dashed fs-6 gy-3" id="kt_table_widget_5_table">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                        <th class="text-center pe-3 min-w-100px">Date</th>
                        <th class="text-center min-w-150px">In Selfie</th>
                        <th class="text-center pe-3 min-w-150px">In Time</th>
                        <th class="text-center min-w-150px">Out Selfie</th>
                        <th class="text-center min-w-150px">Out Time</th>
                        <th class="text-center pe-3 min-w-150px">Time In Office (min)</th>
                        {{-- <th class="text-center pe-3 min-w-100px">Status</th> --}}
                    </tr>
                </thead>
                <tbody class="fw-bold text-gray-600">
                    {{-- @dd($data); --}}
                    @foreach ($data as $value)
                        <tr>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($value->date)->format('d-m-Y') ?? '' }}
                            </td>
                            <td class="text-center min-w-150px">
                                <a href="{{ $value->in_selfie }}" target="_blank">In Selfie</a>
                            </td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($value->in_time)->format('h:i:s a') ?? '' }}
                            </td>
                            <td class="text-center min-w-150px">
                                <a href="{{ $value->out_selfie }}" target="_blank">Out Selfie</a>
                            </td>
                            <td class="text-center">
                                @if ($value->out_time)
                                    {{ \Carbon\Carbon::parse($value->out_time)->format('h:i:s a') ?? '' }}
                                @endif
                            </td>
                            <td class="text-center">
                                {{ $value->total_minutes ?? '' }} min
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
</div>
