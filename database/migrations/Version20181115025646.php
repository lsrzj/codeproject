<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20181115025646 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE clients (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, responsible VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, obs LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:carbondatetime)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:carbondatetime)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, remember_token VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:carbondatetime)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:carbondatetime)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects (id INT UNSIGNED AUTO_INCREMENT NOT NULL, owner_id INT UNSIGNED NOT NULL, client_id INT UNSIGNED NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, progress NUMERIC(8, 2) NOT NULL, status INT NOT NULL, due_date DATETIME NOT NULL COMMENT \'(DC2Type:carbondatetime)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:carbondatetime)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:carbondatetime)\', INDEX IDX_5C93B3A47E3C61F9 (owner_id), INDEX IDX_5C93B3A419EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_members (project_id INT UNSIGNED NOT NULL, user_id INT UNSIGNED NOT NULL, INDEX IDX_D3BEDE9A166D1F9C (project_id), INDEX IDX_D3BEDE9AA76ED395 (user_id), PRIMARY KEY(project_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_notes (id INT UNSIGNED AUTO_INCREMENT NOT NULL, project_id INT UNSIGNED NOT NULL, title VARCHAR(255) NOT NULL, note LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:carbondatetime)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:carbondatetime)\', INDEX IDX_124EAF12166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_tasks (id INT UNSIGNED AUTO_INCREMENT NOT NULL, project_id INT UNSIGNED NOT NULL, name VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL COMMENT \'(DC2Type:carbondatetime)\', due_date DATETIME NOT NULL COMMENT \'(DC2Type:carbondatetime)\', status INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:carbondatetime)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:carbondatetime)\', INDEX IDX_430D6C09166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A47E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A419EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE project_members ADD CONSTRAINT FK_D3BEDE9A166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_members ADD CONSTRAINT FK_D3BEDE9AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_notes ADD CONSTRAINT FK_124EAF12166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE project_tasks ADD CONSTRAINT FK_430D6C09166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A419EB6921');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A47E3C61F9');
        $this->addSql('ALTER TABLE project_members DROP FOREIGN KEY FK_D3BEDE9AA76ED395');
        $this->addSql('ALTER TABLE project_members DROP FOREIGN KEY FK_D3BEDE9A166D1F9C');
        $this->addSql('ALTER TABLE project_notes DROP FOREIGN KEY FK_124EAF12166D1F9C');
        $this->addSql('ALTER TABLE project_tasks DROP FOREIGN KEY FK_430D6C09166D1F9C');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE project_members');
        $this->addSql('DROP TABLE project_notes');
        $this->addSql('DROP TABLE project_tasks');
    }
}
