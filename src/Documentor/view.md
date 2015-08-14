
---
## {{ className }}
{% spaceless %}
{{ description }}
{{ longDescription|raw }}
{% if methods %}
{# Methods #}
{% endif %}
{% for method in methods %}

##### ``{{ method.visibility }}`` {{ method.name }}()
    {{ method.description }}{% if method.arguments.count %}

Argument   | Type          | Description
------------| :-------------| :-------------
        {% for argument in method.arguments %}{{ argument.name }} | {{ argument.type }} | {{ argument.description }}
        {% endfor %}

    {% endif %}
{% endfor %}
{% endspaceless %}
