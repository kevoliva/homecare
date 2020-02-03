<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200203135139 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE alerte (id INT AUTO_INCREMENT NOT NULL, bien_id INT NOT NULL, libelle VARCHAR(100) NOT NULL, la_date DATE NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_3AE753ABD95B80F (bien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE autorisation (id INT AUTO_INCREMENT NOT NULL, professionnel_id INT NOT NULL, bien_id INT NOT NULL, plan TINYINT(1) NOT NULL, facture TINYINT(1) NOT NULL, intervention TINYINT(1) NOT NULL, alerte TINYINT(1) NOT NULL, INDEX IDX_9A431348A49CC82 (professionnel_id), INDEX IDX_9A43134BD95B80F (bien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bien (id INT AUTO_INCREMENT NOT NULL, proprietaire_id INT NOT NULL, adresse VARCHAR(200) NOT NULL, ville VARCHAR(100) NOT NULL, code_postal VARCHAR(6) NOT NULL, date_construct DATE NOT NULL, surface INT NOT NULL, INDEX IDX_45EDC38676C50E4A (proprietaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, bien_id INT NOT NULL, libelle VARCHAR(100) NOT NULL, la_date DATE NOT NULL, chemin_fic VARCHAR(250) NOT NULL, INDEX IDX_FE866410BD95B80F (bien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention (id INT AUTO_INCREMENT NOT NULL, bien_id INT NOT NULL, alerte_id INT DEFAULT NULL, libelle VARCHAR(100) NOT NULL, type_interv VARCHAR(100) NOT NULL, observation LONGTEXT NOT NULL, remarque LONGTEXT DEFAULT NULL, INDEX IDX_D11814ABBD95B80F (bien_id), UNIQUE INDEX UNIQ_D11814AB2C9BA629 (alerte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plan (id INT AUTO_INCREMENT NOT NULL, bien_id INT NOT NULL, libelle VARCHAR(100) NOT NULL, la_date DATE NOT NULL, chemin_fic VARCHAR(250) NOT NULL, INDEX IDX_DD5A5B7DBD95B80F (bien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professionnel (id INT AUTO_INCREMENT NOT NULL, nom_entrep VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE alerte ADD CONSTRAINT FK_3AE753ABD95B80F FOREIGN KEY (bien_id) REFERENCES bien (id)');
        $this->addSql('ALTER TABLE autorisation ADD CONSTRAINT FK_9A431348A49CC82 FOREIGN KEY (professionnel_id) REFERENCES professionnel (id)');
        $this->addSql('ALTER TABLE autorisation ADD CONSTRAINT FK_9A43134BD95B80F FOREIGN KEY (bien_id) REFERENCES bien (id)');
        $this->addSql('ALTER TABLE bien ADD CONSTRAINT FK_45EDC38676C50E4A FOREIGN KEY (proprietaire_id) REFERENCES proprietaire (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410BD95B80F FOREIGN KEY (bien_id) REFERENCES bien (id)');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814ABBD95B80F FOREIGN KEY (bien_id) REFERENCES bien (id)');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB2C9BA629 FOREIGN KEY (alerte_id) REFERENCES alerte (id)');
        $this->addSql('ALTER TABLE plan ADD CONSTRAINT FK_DD5A5B7DBD95B80F FOREIGN KEY (bien_id) REFERENCES bien (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814AB2C9BA629');
        $this->addSql('ALTER TABLE alerte DROP FOREIGN KEY FK_3AE753ABD95B80F');
        $this->addSql('ALTER TABLE autorisation DROP FOREIGN KEY FK_9A43134BD95B80F');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410BD95B80F');
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814ABBD95B80F');
        $this->addSql('ALTER TABLE plan DROP FOREIGN KEY FK_DD5A5B7DBD95B80F');
        $this->addSql('ALTER TABLE autorisation DROP FOREIGN KEY FK_9A431348A49CC82');
        $this->addSql('DROP TABLE alerte');
        $this->addSql('DROP TABLE autorisation');
        $this->addSql('DROP TABLE bien');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE intervention');
        $this->addSql('DROP TABLE plan');
        $this->addSql('DROP TABLE professionnel');
    }
}
