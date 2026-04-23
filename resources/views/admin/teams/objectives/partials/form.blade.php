<div class="row g-3">

    <div class="col-md-4">
        <label>Année</label>
        <input type="number"
               name="year"
               class="form-control"
               value="{{ old('year', $objective->year ?? date('Y')) }}">
    </div>

    <div class="col-md-4">
        <label>Objectif principal</label>
        <input type="text"
               name="main_goal"
               class="form-control"
               value="{{ old('main_goal', $objective->main_goal ?? '') }}">
    </div>

    <div class="col-md-4">
        <label>Budget prévisionnel</label>
        <input type="number"
               step="0.01"
               name="budget_forecast"
               class="form-control"
               value="{{ old('budget_forecast', $objective->budget_forecast ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>KPI / Indicateurs</label>
        <textarea name="kpis"
                  class="form-control"
                  rows="3">{{ old('kpis', $objective->kpis ?? '') }}</textarea>
    </div>

    <div class="col-md-6 mb-3">
        <label>Activités ciblées</label>
        <textarea name="target_activities"
                  class="form-control"
                  rows="3">{{ old('target_activities', $objective->target_activities ?? '') }}</textarea>
    </div>

</div>