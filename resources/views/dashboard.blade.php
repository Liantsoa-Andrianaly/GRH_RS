
    @extends('layouts.template')

    @section('content')

    <h2 class="mb-4 text-center text-primary" style="font-family:poppins">TABLEAU DE BORD</h2>
        <!--a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-fw fa-chart-area"></i> Configuration
        </a-->
  
        <div class="alert alert-warning"><b>Ceci est le tableau de bord RH </div>

    
    <div class="row">

    <!-- Total employés -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total des employés
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalEmployees }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total agences -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total des agences et des antennes
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalAgences ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-building fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total des services</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalServices }} </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-sitemap fa-2x text-gray-300"></i>


                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="col-md-3 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Employés supprimés
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalSupprimes }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-slash fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Répartition par service -->
    <div class="col-xl-6 col-md-12 mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-header">Répartition des employés par service</div>
            <div class="card-body">
                <canvas id="serviceChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Répartition par agence -->
    <div class="col-xl-6 col-md-12 mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-header">Répartition des employés par agence</div>
            <div class="card-body">
                <canvas id="agenceChart"></canvas>
            </div>
        </div>
    </div>



</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const serviceCtx = document.getElementById('serviceChart').getContext('2d');
    const serviceChart = new Chart(serviceCtx, {
        type: 'pie',
        data: {
            labels: @json($employeesByService->keys()),
            datasets: [{
                data: @json($employeesByService->values()),
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    const agenceCtx = document.getElementById('agenceChart').getContext('2d');
    const agenceChart = new Chart(agenceCtx, {
        type: 'bar',
        data: {
            labels: @json($employeesByAgence->keys()),
            datasets: [{
                label: 'Nombre d\'employés',
                data: @json($employeesByAgence->values()),
                backgroundColor: '#4e73df'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            
                            return Number.isInteger(value) ? value : null;
                        }
                    }
                }
            }
        }
    });

</script>

    @endsection