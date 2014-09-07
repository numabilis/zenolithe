INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'page_postscollection_name', 'fr', 'Liste d''articles');

CREATE TABLE cms_categories (
    cat_id BIGSERIAL PRIMARY KEY,
    cat_site_id BIGINT,
    cat_name VARCHAR(256) DEFAULT '',
    cat_parent_page_group BIGINT
);

INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'module_posts_name', 'fr', 'Billets');

CREATE TABLE cms_posts (
    pot_article_id BIGINT,
    pot_category_id BIGINT,
    PRIMARY KEY(pot_article_id, pot_category_id)
);

ALTER TABLE cms_articles ADD COLUMN art_page_id BIGINT REFERENCES cms_pages (pge_id);
ALTER TABLE cms_articles ADD COLUMN art_type VARCHAR(128) DEFAULT '';
UPDATE cms_articles SET art_type = SUBSTRING(art_parameter FROM 0 FOR POSITION('/' IN art_parameter));
UPDATE cms_articles SET art_page_id = SUBSTRING(art_parameter FROM POSITION('/' IN art_parameter)+1)::BIGINT;
ALTER TABLE cms_articles DROP COLUMN art_parameter;

UPDATE cms_pages SET pge_controller = 'cms/articles.view' WHERE pge_controller = 'cms/pages.article.view';
