{set-block scope=root variable=subject}{"Collected information from %1"|i18n("design/standard/content/edit",,array($collection.object.name))}{/set-block}

{set-block scope=root variable=email_receiver}{$object.data_map.send_to_email.content}{/set-block}

{* Set this to redirect to another node
{set-block scope=root variable=redirect_to_node_id}2{/set-block}
*}

{"The following information was collected:"|i18n("design/standard/content/edit")}

{section name=Attribute loop=$collection.attributes}
{$Attribute:item.contentclass_attribute_name}:
{$Attribute:item.data_text|wash}


{/section}

