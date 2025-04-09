<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лиды из AMO CRM</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<h1>Список лидов</h1>

<form method="GET">
    <label>Статус ID: <input type="text" name="status_id" value="{{ request('status_id') }}"></label>
    <label>Дата обновления от: <input type="date" name="updated_at_from" value="{{ request('updated_at_from') }}"></label>
    <label>до: <input type="date" name="updated_at_to" value="{{ request('updated_at_to') }}"></label>
    <label>На странице:
        <select name="limit">
            <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
            <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>25</option>
            <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50</option>
        </select>
    </label>
    <button type="submit">Фильтровать</button>
</form>

<table>
    <thead>
    <tr>
        <th>Название</th>
        <th>Статус</th>
        <th>Контакт</th>
        <th>Изменён</th>
    </tr>
    </thead>
    <tbody>
    @forelse($leads as $lead)
        <tr>
            <td>{{ $lead['name'] }}</td>
            <td>{{ $lead['status_id'] }}</td>
            <td>{{ $lead['_embedded']['contacts'][0]['name'] ?? '—' }}</td>
            <td>{{ date('d.m.Y H:i', strtotime($lead['updated_at'])) }}</td>
        </tr>
    @empty
        <tr><td colspan="4">Нет данных</td></tr>
    @endforelse
    </tbody>
</table>

<div class="pagination">
    @for ($i = 1; $i <= $page + 2; $i++)
        <a href="?{{ http_build_query(array_merge(request()->except('page'), ['page' => $i])) }}" {{ $i == $page ? 'style=color:red;' : '' }}>{{ $i }}</a>
    @endfor
</div>
</body>
</html>
