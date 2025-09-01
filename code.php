<style>
:root {
    --primary: #1c355c;
    --secondary: #3498db;
    --accent: #f39c12;
    --light: #f8f9fa;
    --dark: #212529;
    --success: #28a745;
    --border-radius: 8px;
    --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    --transition: all 0.3s ease;
}

* {
    margin: 0;
    padding: 5px;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background: #daa520;
    color: var(--dark);
    line-height: 1.6;
    padding: 20px;
    min-height: 100vh;
}

.container {
    max-width: 90%;
    margin: 0 auto;
}

header {
    background: linear-gradient(to right, var(--primary), #2c5282);
    color: white;
    padding: 25px;
    border-radius: var(--border-radius) var(--border-radius) 0 0;
    text-align: center;
    margin-bottom: 25px;
    box-shadow: var(--box-shadow);
}

.audit-info {
    background: #e3f2fd;
    border-left: 4px solid var(--secondary);
    padding: 15px 20px;
    margin-bottom: 25px;
    border-radius: var(--border-radius);
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: var(--box-shadow);
}

.audit-info i {
    color: var(--secondary);
    font-size: 1.4rem;
}

.form-container {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    overflow: hidden;
    margin-bottom: 30px;
}

.form-section {
    padding: 25px;
    border-bottom: 1px solid #eaeaea;
}

.form-section:last-child {
    border-bottom: none;
}

.section-header {
    background: linear-gradient(to right, #1c355c, #2c5282);
    color: white;
    padding: 15px 20px;
    border-radius: 8px;
    cursor: pointer;
    margin-bottom: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.section-header:hover {
    background: linear-gradient(to right, #152642, #1a3e6b);
}

.section-header h3 {
    margin: 0;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-header i {
    transition: var(--transition);
}

.section-content {
    padding: 0 20px;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-out;
    background: #f8fafc;
    border-radius: 8px;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 22px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--dark);
    display: flex;
    align-items: center;
    gap: 5px;
}

.form-group label i {
    color: var(--secondary);
}

.required label:after {
    content: " *";
    color: var(--accent);
}

input,
select,
textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #d1d5db;
    border-radius: var(--border-radius);
    font-size: 1rem;
    transition: var(--transition);
    background: #f8fafc;
}

input:focus,
select:focus,
textarea:focus {
    outline: none;
    border-color: var(--secondary);
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    background: white;
}

input[type="checkbox"],
input[type="radio"] {
    width: auto;
    margin-right: 8px;
}

.checkbox-group,
.radio-group {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-top: 8px;
}

.checkbox-item,
.radio-item {
    display: flex;
    align-items: center;
    background: #f1f8ff;
    padding: 10px 15px;
    border-radius: var(--border-radius);
    flex: 1 0 200px;
}

/* FIXED: Sub-options grid layout */
.sub-options {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    background: #f0f9ff;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #3498db;
    margin-top: 15px;
    display: none;
    /* Initially hidden */
}

.tank-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-top: 15px;
}

.tank-card {
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    margin-bottom: 20px;
}

.tank-card h4 {
    color: var(--primary);
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.tank-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transform: translateY(-3px);
}

.form-footer {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    padding: 25px;
    background: #f8fafc;
    border-top: 1px solid #eaeaea;
}

.btn {
    padding: 12px 30px;
    border: none;
    border-radius: var(--border-radius);
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 8px;
}

.checkbox-item {
    display: flex;
    align-items: center;
    background: #f1f8ff;
    padding: 12px 15px;
    border-radius: 8px;
    flex: 1 0 200px;
    transition: all 0.3s ease;
}

.checkbox-item:hover {
    background: #e3f2fd;
    transform: translateY(-2px);
}

.btn-primary {
    background: var(--primary);
    color: white;
}

.btn-primary:hover {
    background: #152642;
    transform: translateY(-2px);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

.toggle-icon {
    transition: transform 0.3s ease;
}

.toggle-icon.rotated {
    transform: rotate(180deg);
}

.collapsed .toggle-icon {
    transform: rotate(0deg);
}

.expanded .toggle-icon {
    transform: rotate(180deg);
}

.section-collapse {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-out;
}

.section-content {
    max-height: 2000px;
    transition: max-height 0.5s ease-in;
    display: grid;
}

.collapsed .section-content {
    max-height: 0;
    overflow: hidden;
}

.form-group .hint {
    font-size: 0.85rem;
    color: #6b7280;
    margin-top: 5px;
    font-style: italic;
}

.success-message {
    background-color: #d4edda;
    color: #155724;
    padding: 15px;
    border-radius: 5px;
    margin: 20px 0;
    text-align: center;
    display: none;
}

@media (max-width: 1200px) {
    .sub-options {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .section-content {
        grid-template-columns: 1fr;
    }

    .tank-grid {
        grid-template-columns: 1fr;
    }

    .form-footer {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }

    .sub-options {
        grid-template-columns: 1fr;
    }
}

.modal-btn {
    padding: 16px 50px;
    border-radius: 50px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    background: goldenrod;
    color: white;
    margin: auto;
    font-size: medium;
    min-width: 30%;
}

.modal-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    background: #1c355c;
}
</style>