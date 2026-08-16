<?php
namespace App\Services;
use App\Services\FemaNfhlService;


class ApiTester{
    public function __construct(
        protected FemaNfhlService $femaNfhlService,
        protected FemaNriService $femaNriService,
        protected OpenFemaService $openFemaService,
        protected NoaaNhcService $noaaNhcService,
        protected NoaaSeaLevelRiseService $noaaSeaLevelRiseService,
        protected UsGssNwisService $usGssNwisService,
        protected UsGssStreamStatsService $usGssStreamStatsService,
        protected UsgsNhdService $usgsNhdService,
        protected UsgsWbdService $usgsWbdService,
        protected EpaEnvirofactsService $epaEnvirofactsService,
        protected EpaEchoService $epaEchoService,
        protected AirNowService $airNowService,
        protected EpaSemsService $epaSemsService,
        protected EpaAcresService $epaAcresService,
        protected UsgsEarthquakeService $usgsEarthquakeService,
        protected UsdaNrcsService $usdaNrcsService,
        protected UsgsMrdsService $usgsMrdsService,
        protected UsdaNrcsSsurgoService $usdaNrcsSsurgoService,
        protected UsdaCropScapeService $usdaCropScapeService,
        protected UsdaNassQuickStatsService $usdaNassQuickStatsService

    ){}

    public function testAll():array{
        return[
            // $this->femaNfhlService->fetchData(), //notfound
            // $this->femaNriService->fetchData(), //working
            // $this->openFemaService->fetchData(), //working
            // $this->noaaNhcService->fetchData(), //working
            // $this->noaaSeaLevelRiseService->fetchData(), //working
            // $this->usGssNwisService->fetchData(), //working
            // $this->usGssStreamStatsService->fetchData(),//working
            // $this->usgsNhdService->fetchData(), //working
            // $this->usgsWbdService->fetchData(), //working
            // $this->epaEnvirofactsService->fetchData(), //working
            // $this->epaEchoService->fetchData(),// working
            // $this->airNowService->fetchData(), //working
            // $this->epaSemsService->fetchData(), //working
            // $this->epaAcresService->fetchData(), //working
            // $this->usgsEarthquakeService->fetchData(), //working
            // $this->usdaNrcsService->fetchData(), //working
            // $this->usgsMrdsService->fetchData(),//working
            $this->usdaNrcsSsurgoService->fetchData(),//testing
            // $this->usdaCropScapeService->fetchData(),//working but gives url for data
            // $this->usdaNassQuickStatsService->fetchData(),//working




            






        ];
    }
}


?>