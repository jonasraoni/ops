{**
 * replaceReviewer.tpl
 *
 * Copyright (c) 2003-2004 The Public Knowledge Project
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * List reviewers and give the ability to select a reviewer.
 *
 * $Id$
 *}

{assign var="pageTitle" value="submission.reviewer"}
{include file="common/header.tpl"}

<div class="subTitle">{translate key="submission.replaceReviewer"}</div>

<table width="100%">
<tr class="heading">
	<td>{translate key="user.username"}</td>
	<td>{translate key="user.name"}</td>
	<td></td>
</tr>
{foreach from=$reviewers item=reviewer}
<tr class="{cycle values="row,rowAlt"}">
	<td><a href="{$requestPageUrl}/replaceReviewer/{$articleId}/{$reviewId}/{$reviewer->getUserId()}">{$reviewer->getUsername()}</a></td>
	<td width="100%">{$reviewer->getFullName()}</td>
	<td><a href="{$requestPageUrl}/replaceReviewer/{$articleId}/{$reviewId}/{$reviewer->getUserId()}" class="tableAction">Assign</a></td>
</tr>
{foreachelse}
<tr>
<td colspan="3" class="noResults">{translate key="manager.people.noneEnrolled"}</td>
</tr>
{/foreach}
</table>

{include file="common/footer.tpl"}
