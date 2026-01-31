<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* modules/custom/news_front/templates/news-front-template.html.twig */
class __TwigTemplate_812bd5fbdc71ee97f3810c0625f4a74e extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css\" rel=\"stylesheet\" />

<style>
  /* Fix for the Featured Spotlight (Drupal-rendered content) */
  #featured-content img {
    width: 100%;
    height: 300px; 
    object-fit: cover; 
    border-radius: 0; 
  }

  
  .node--type-article .field--name-field-image img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 20px;
  }
</style>

<div class=\"container py-5\">
  <div class=\"row g-4\">
    <div class=\"col-md-7\">
      <div class=\"card h-100 border-0 shadow-sm overflow-hidden\">
        <div class=\"card-header bg-primary text-white py-3\">
          <h2 class=\"h4 mb-0\">Featured Spotlight</h2>
        </div>
        <div class=\"card-body p-0\">
          <div id=\"featured-content\">
             ";
        // line 30
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["featured_node"] ?? null), "html", null, true);
        yield "
          </div>
        </div>
      </div>
    </div>

    <div class=\"col-md-5\">
      <h2 class=\"h4 mb-4 text-dark border-bottom pb-2\">Latest News</h2>
      <div id=\"news-feed\">
        <div class=\"p-3 text-muted text-center\">
            <div class=\"spinner-border text-primary\" role=\"status\"></div>
        </div>
      </div>
    </div>
  </div>

  <script>
    fetch(\"/api/news?_format=json\")
      .then((res) => res.json())
      .then((data) => {
        const container = document.getElementById(\"news-feed\");
        container.innerHTML = \"\";

        if (!data || data.length === 0) {
          container.innerHTML = '<div class=\"alert alert-info\">No news articles found.</div>';
          return;
        }

        data.forEach((item) => {
          const title = item.title[0]?.value || \"Untitled\";
          const bodyRaw = item.body[0]?.processed || \"\";
          const bodySnippet = bodyRaw.replace(/<[^>]*>/g, \"\").substring(0, 80);
          const link = `/node/\${item.nid[0]?.value}`;
          
          // Image logic for JS feed
          const imageUrl = item.field_image && item.field_image[0] ? item.field_image[0].url : '';
          
          const imageHtml = imageUrl 
            ? `<div class=\"col-4\">
                 <img src=\"\${imageUrl}\" class=\"img-fluid h-100\" style=\"object-fit: cover; min-height: 100px;\" alt=\"\${title}\">
               </div>`
            : '';

          container.innerHTML += `
            <div class=\"card mb-3 shadow-sm border-0 overflow-hidden\">
              <div class=\"row g-0\">
                \${imageHtml}
                <div class=\"\${imageUrl ? 'col-8' : 'col-12'}\">
                  <div class=\"card-body p-3\">
                    <h6 class=\"card-title mb-1\">
                      <a href=\"\${link}\" class=\"text-decoration-none text-dark fw-bold\">\${title}</a>
                    </h6>
                    <p class=\"card-text small text-muted mb-0\">\${bodySnippet}...</p>
                  </div>
                </div>
              </div>
            </div>`;
        });
      })
      .catch((err) => {
        console.error(\"API Error:\", err);
        document.getElementById(\"news-feed\").innerHTML = '<div class=\"alert alert-danger\">Error loading feed.</div>';
      });
  </script>
</div>";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["featured_node"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "modules/custom/news_front/templates/news-front-template.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  75 => 30,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "modules/custom/news_front/templates/news-front-template.html.twig", "/home/dickyv/repos/drupal_news/web/modules/custom/news_front/templates/news-front-template.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = [];
        static $filters = ["escape" => 30];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                [],
                ['escape'],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
