
<style>
    .um-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 48px 24px 80px;
    }

    .um-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 42px;
        font-weight: 400;
        margin-bottom: 8px;
    }

    .um-subtitle {
        color: #777;
        font-size: 13px;
        margin-bottom: 28px;
    }

    .um-card {
        background: white;
        border: 1px solid #e8e0d6;
        border-radius: 10px;
        padding: 22px;
        margin-bottom: 24px;
    }

    .um-form {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .um-input, .um-select {
        padding: 12px;
        border: 1px solid #ddd6ce;
        background: white;
        font-family: inherit;
        min-width: 180px;
    }

    .um-input {
        flex: 1;
    }

    .um-btn {
        display: inline-block;
        padding: 10px 15px;
        border: 1px solid #111;
        background: #111;
        color: white;
        border-radius: 5px;
        font-size: 12px;
        text-decoration: none;
        cursor: pointer;
    }

    .um-btn-outline {
        background: white;
        color: #111;
    }

    .um-btn-danger {
        background: #a42626;
        border-color: #a42626;
    }

    .um-btn:disabled {
        opacity: .4;
        cursor: not-allowed;
    }

    .um-table-wrap {
        overflow-x: auto;
    }

    .um-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .um-table th, .um-table td {
        padding: 14px 12px;
        text-align: left;
        border-bottom: 1px solid #eee7df;
        vertical-align: middle;
    }

    .um-table th {
        background: #f8f5f0;
        font-weight: 500;
        white-space: nowrap;
    }

    .um-muted {
        color: #888;
        font-size: 12px;
    }

    .um-badge {
        display: inline-block;
        padding: 5px 9px;
        background: #e6f5eb;
        color: #176a39;
        border-radius: 4px;
        font-size: 11px;
    }

    .um-badge-blocked {
        background: #fbe6e6;
        color: #a42626;
    }

    .um-actions {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    .um-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-top: 20px;
    }

    .um-info {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .um-info div {
        padding: 10px 0;
        border-bottom: 1px solid #eee7df;
    }

    .um-info span {
        display: block;
        color: #888;
        font-size: 12px;
        margin-bottom: 5px;
    }

    @media(max-width: 650px) {
        .um-title { font-size: 32px; }
        .um-info { grid-template-columns: 1fr; }
        .um-pagination { flex-wrap: wrap; }
    }
</style>
