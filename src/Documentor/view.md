---

## {{ className }}

{{ description }}
{{ longDescription|raw }}
{% if methods %}
{# Methods #}
{% endif %}
{% for method in methods %}

##### ``{{ method.visibility }}`` {{ method.name }}()
    {{ method.description }}
    {% if method.arguments.count %}
 {#
     <!--arguments-->
Argument   | Type          | Description
------------| :-------------| :------------- #}
        {% for argument in method.arguments %}
* {{ argument.name }}
        {% endfor %}
    {% endif %}
{% endfor %}
