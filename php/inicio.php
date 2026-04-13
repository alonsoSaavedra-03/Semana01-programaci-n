<div id="moduloDashboard">
  <div class="kpi-grid">
    
    <div class="kpi-card">
      <div class="kpi-icon">
        <i class="fa-solid fa-users"></i>
      </div>
      <div class="kpi-info">
        <h3>Total Alumnos</h3>
        <h2 id="kpiTotalAlumnos">0</h2>
      </div>
    </div>

    <div class="kpi-card">
      <div class="kpi-icon">
        <i class="fa-solid fa-school"></i>
      </div>
      <div class="kpi-info">
        <h3>Aulas Activas</h3>
        <h2 id="kpiTotalAulas">0</h2>
      </div>
    </div>

    <div class="kpi-card">
      <div class="kpi-icon">
        <i class="fa-solid fa-ticket"></i>
      </div>
      <div class="kpi-info">
        <h3>Vacantes Disp.</h3>
        <h2 id="kpiVacantesDisp">0</h2>
      </div>
    </div>

  </div>

  <div class="charts-grid">
    
    <div class="card chart-card">
      <div class="card-header">
        <h2>Alumnos por Género</h2>
      </div>
      <div class="card-body">
        <canvas id="graficoGenero"></canvas>
      </div>
    </div>

    <div class="card chart-card">
      <div class="card-header">
        <h2>Vacantes por Nivel Educativo</h2>
      </div>
      <div class="card-body">
        <canvas id="graficoNiveles"></canvas>
      </div>
    </div>

  </div>
</div>