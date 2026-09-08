-- Esquema de base de datos para ASII-24 Semana 4 (Patron Repository y Persistencia)

CREATE TABLE IF NOT EXISTS documents (
    id VARCHAR(64) PRIMARY KEY,
    code VARCHAR(64) NOT NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    summary TEXT NOT NULL,
    content TEXT NOT NULL,
    owner_scope VARCHAR(32) NOT NULL CHECK (owner_scope IN ('CENTRAL', 'HOSPITAL')),
    hospital_uuid VARCHAR(64) NULL,
    status VARCHAR(32) NOT NULL DEFAULT 'PUBLISHED',
    published_at DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS document_roles (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    document_id VARCHAR(64) NOT NULL,
    role_name VARCHAR(64) NOT NULL,
    FOREIGN KEY (document_id) REFERENCES documents(id) ON DELETE CASCADE,
    UNIQUE(document_id, role_name)
);

CREATE INDEX IF NOT EXISTS idx_documents_code ON documents(code);
CREATE INDEX IF NOT EXISTS idx_documents_owner ON documents(owner_scope);
CREATE INDEX IF NOT EXISTS idx_doc_roles_role ON document_roles(role_name);
