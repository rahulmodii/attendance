<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar pt-2 pt-lg-10">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">
                        Dashboard</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted"> <a href="/"
                                class="text-muted text-hover-primary">Home</a> </li>
                        <li class="breadcrumb-item"> <span class="bullet bg-gray-500 w-5px h-2px"></span> </li>
                        <li class="breadcrumb-item text-muted">Dashboards</li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <input type="date" wire:model.live='filterdate' class="form-control" />
                </div>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="row g-5 g-xl-10">
                @foreach ($data as $value)
                    <div class="col-xl-4 mb-xl-10">
                        <div class="card card-flush h-xl-100">
                            <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px"
                                style="background-image:url('assets/media/svg/shapes/top-green.png"
                                data-bs-theme="light">
                                <h3 class="card-title align-items-start flex-column text-white pt-15"> <span
                                        class="fw-bold fs-2x mb-3">Attendance</span>
                                    <div class="fs-4 text-white">
                                        <span class="">Employee Name: {{ $value->name ?? '' }}</span><br/>
                                        <span class="">Date: {{ $filterdate ?? '' }}</span>
                                    </div>
                                </h3>
                                <div class="card-toolbar pt-5">
                                    {{-- <button
                                    class="btn btn-sm btn-icon btn-active-color-primary btn-color-white bg-white bg-opacity-25 bg-hover-opacity-100 bg-hover-white bg-active-opacity-25 w-20px h-20px"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                    data-kt-menu-overflow="true"> <i class="ki-outline ki-dots-square fs-4"></i>
                                </button> --}}
                                </div>
                            </div>
                            <div class="card-body mt-n20">
                                <div class="mt-n20 position-relative">
                                    <div class="row g-3 g-lg-6">
                                        <div class="col-6">
                                            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                                <div class="symbol symbol-30px me-5 mb-8"> <span class="symbol-label">
                                                        <i class="ki-outline ki-flask fs-1 text-primary"></i> </span>
                                                </div>
                                                <div class="m-0"> <span
                                                        class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ $value->totalMinute ?? '' }}</span>
                                                    <span class="text-gray-500 fw-semibold fs-6">Total minutes</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                                <div class="symbol symbol-30px me-5 mb-8"> <span class="symbol-label">
                                                        <i class="ki-outline ki-bank fs-1 text-primary"></i> </span>
                                                </div>
                                                <div class="m-0">
                                                    <span
                                                        class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">
                                                        @php
                                                            $timeFormatted = \Carbon\CarbonInterval::minutes($value->totalMinute)
                                                                ->cascade()
                                                                ->forHumans([
                                                                    'short' => true, // Shortens the format, e.g., "2h 5m"
                                                                    'parts' => 2, // Limits to 2 components, e.g., "2h 5m" instead of "2h 5m 0s"
                                                                ]);

                                                        @endphp
                                                        {{ $timeFormatted ?? ''}}
                                                    </span>
                                                    <span class="text-gray-500 fw-semibold fs-6">Total time in
                                                        hours</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                                <div class="symbol symbol-30px me-5 mb-8"> <span class="symbol-label">
                                                        <i class="ki-outline ki-award fs-1 text-primary"></i> </span>
                                                </div>
                                                <div class="m-0"> <span
                                                        class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ $value->first_in_time ?? '' }}</span>
                                                    <span class="text-gray-500 fw-semibold fs-6">Check In time</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                                <div class="symbol symbol-30px me-5 mb-8"> <span class="symbol-label">
                                                        <i class="ki-outline ki-timer fs-1 text-primary"></i> </span>
                                                </div>
                                                <div class="m-0"> <span
                                                        class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ $value->first_out_time ?? '' }}</span>
                                                    <span class="text-gray-500 fw-semibold fs-6">Check out time</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
