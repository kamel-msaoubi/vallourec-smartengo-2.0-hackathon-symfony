<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211031234857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT IDENTITY(1,1), users_id INT, name NVARCHAR(255) NOT NULL, reference NVARCHAR(255), content VARCHAR(MAX), draft BIT, created_at DATETIME2(6) NOT NULL, updated_at DATETIME2(6), PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_23A0E6667B3B43D ON article (users_id)');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:datetime_immutable)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'article\', N\'COLUMN\', created_at');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:datetime_immutable)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'article\', N\'COLUMN\', updated_at');
        $this->addSql('CREATE TABLE comment (id INT IDENTITY(1,1), articles_id INT, users_id INT, content VARCHAR(MAX) NOT NULL, created_at DATETIME2(6) NOT NULL, updated_at DATETIME2(6), PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_9474526C1EBAF6CC ON comment (articles_id)');
        $this->addSql('CREATE INDEX IDX_9474526C67B3B43D ON comment (users_id)');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:datetime_immutable)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'comment\', N\'COLUMN\', created_at');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:datetime_immutable)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'comment\', N\'COLUMN\', updated_at');
        $this->addSql('CREATE TABLE reaction (id INT IDENTITY(1,1), articles_id INT, users_id INT, type NVARCHAR(255) NOT NULL, created_at DATETIME2(6) NOT NULL, updated_at DATETIME2(6), PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_A4D707F71EBAF6CC ON reaction (articles_id)');
        $this->addSql('CREATE INDEX IDX_A4D707F767B3B43D ON reaction (users_id)');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:datetime_immutable)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'reaction\', N\'COLUMN\', created_at');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:datetime_immutable)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'reaction\', N\'COLUMN\', updated_at');
        $this->addSql('CREATE TABLE tag (id INT IDENTITY(1,1), title NVARCHAR(255), created_at DATETIME2(6) NOT NULL, updated_at DATETIME2(6), PRIMARY KEY (id))');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:datetime_immutable)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'tag\', N\'COLUMN\', created_at');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:datetime_immutable)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'tag\', N\'COLUMN\', updated_at');
        $this->addSql('CREATE TABLE tag_article (tag_id INT NOT NULL, article_id INT NOT NULL, PRIMARY KEY (tag_id, article_id))');
        $this->addSql('CREATE INDEX IDX_300B23CCBAD26311 ON tag_article (tag_id)');
        $this->addSql('CREATE INDEX IDX_300B23CC7294869C ON tag_article (article_id)');
        $this->addSql('CREATE TABLE users_roles (user_id INT NOT NULL, roles_id INT NOT NULL, PRIMARY KEY (user_id, roles_id))');
        $this->addSql('CREATE INDEX IDX_51498A8EA76ED395 ON users_roles (user_id)');
        $this->addSql('CREATE INDEX IDX_51498A8E38C751C4 ON users_roles (roles_id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6667B3B43D FOREIGN KEY (users_id) REFERENCES [users] (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C1EBAF6CC FOREIGN KEY (articles_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C67B3B43D FOREIGN KEY (users_id) REFERENCES [users] (id)');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F71EBAF6CC FOREIGN KEY (articles_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F767B3B43D FOREIGN KEY (users_id) REFERENCES [users] (id)');
        $this->addSql('ALTER TABLE tag_article ADD CONSTRAINT FK_300B23CCBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_article ADD CONSTRAINT FK_300B23CC7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_roles ADD CONSTRAINT FK_51498A8EA76ED395 FOREIGN KEY (user_id) REFERENCES [users] (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_roles ADD CONSTRAINT FK_51498A8E38C751C4 FOREIGN KEY (roles_id) REFERENCES roles (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE user_roles');
        $this->addSql('ALTER TABLE roles ALTER COLUMN name NVARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE roles ALTER COLUMN createdAt DATETIME2(6) NOT NULL');
        $this->addSql('ALTER TABLE roles ALTER COLUMN updatedAt DATETIME2(6) NOT NULL');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:datetime_immutable)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'roles\', N\'COLUMN\', createdAt');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:datetime_immutable)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'roles\', N\'COLUMN\', updatedAt');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA db_accessadmin');
        $this->addSql('CREATE SCHEMA db_backupoperator');
        $this->addSql('CREATE SCHEMA db_datareader');
        $this->addSql('CREATE SCHEMA db_datawriter');
        $this->addSql('CREATE SCHEMA db_ddladmin');
        $this->addSql('CREATE SCHEMA db_denydatareader');
        $this->addSql('CREATE SCHEMA db_denydatawriter');
        $this->addSql('CREATE SCHEMA db_owner');
        $this->addSql('CREATE SCHEMA db_securityadmin');
        $this->addSql('CREATE SCHEMA dbo');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C1EBAF6CC');
        $this->addSql('ALTER TABLE reaction DROP CONSTRAINT FK_A4D707F71EBAF6CC');
        $this->addSql('ALTER TABLE tag_article DROP CONSTRAINT FK_300B23CC7294869C');
        $this->addSql('ALTER TABLE tag_article DROP CONSTRAINT FK_300B23CCBAD26311');
        $this->addSql('CREATE TABLE user_roles (createdAt DATETIMEOFFSET(6) NOT NULL, updatedAt DATETIMEOFFSET(6) NOT NULL, roleId INT NOT NULL, userId INT NOT NULL, PRIMARY KEY (roleId, userId))');
        $this->addSql('CREATE INDEX IDX_54FCD59F64B64DCC ON user_roles (userId)');
        $this->addSql('CREATE INDEX IDX_54FCD59FB8C2FD88 ON user_roles (roleId)');
        $this->addSql('ALTER TABLE user_roles ADD CONSTRAINT FK__user_role__userI__30F848ED FOREIGN KEY (userId) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_roles ADD CONSTRAINT FK__user_role__roleI__300424B4 FOREIGN KEY (roleId) REFERENCES roles (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE reaction');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_article');
        $this->addSql('DROP TABLE users_roles');
        $this->addSql('ALTER TABLE roles ALTER COLUMN id INT NOT NULL');
        $this->addSql('ALTER TABLE roles ALTER COLUMN name NVARCHAR(255) COLLATE SQL_Latin1_General_CP1_CI_AS');
        $this->addSql('ALTER TABLE roles ALTER COLUMN createdAt DATETIMEOFFSET(6) NOT NULL');
        $this->addSql('ALTER TABLE roles ALTER COLUMN updatedAt DATETIMEOFFSET(6) NOT NULL');
        $this->addSql('EXEC sp_dropextendedproperty N\'MS_Description\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'roles\', N\'COLUMN\', createdAt');
        $this->addSql('EXEC sp_dropextendedproperty N\'MS_Description\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'roles\', N\'COLUMN\', updatedAt');
    }
}
