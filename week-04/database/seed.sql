-- Datos semilla para ASII-24 Semana 4

INSERT OR IGNORE INTO documents (id, code, title, summary, content, owner_scope, hospital_uuid, status, published_at)
VALUES 
('doc-001', 'MAN-MED-01', 'Manual de Prescripcion Clinica V2', 'Guia operativa para emision de recetas electronicas', 'Contenido completo del manual clinico para facultativos medicos...', 'CENTRAL', NULL, 'PUBLISHED', '2026-08-20 10:00:00'),
('doc-002', 'GUIA-ENF-01', 'Protocolo de Administracion de Medicamentos', 'Normas de doble verificacion y seguridad en sala', 'Pasos para administracion segura de farmacos intravenosos...', 'HOSPITAL', 'hosp-gt-001', 'PUBLISHED', '2026-08-21 11:30:00'),
('doc-003', 'POL-ADM-01', 'Politica General de Gobernanza de Datos', 'Directrices de cumplimiento HIPAA y aislamiento multitenant', 'Normas de proteccion de expedientes y auditoria central...', 'CENTRAL', NULL, 'PUBLISHED', '2026-08-22 09:00:00');

INSERT OR IGNORE INTO document_roles (document_id, role_name) VALUES
('doc-001', 'Medico'),
('doc-001', 'Admin'),
('doc-002', 'Enfermera'),
('doc-002', 'Admin'),
('doc-003', 'Admin');
