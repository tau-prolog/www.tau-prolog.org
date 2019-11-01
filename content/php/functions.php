<?php

// UTILS

function send_post($url, $str) {
	$opts = array('http' =>
		array(
			'method'  => 'POST',
			'header'  => 'Content-type: application/x-www-form-urlencoded',
			'content' => $str
		)
	);
	$context = stream_context_create($opts);
	return file_get_contents($url, false, $context);
}

// QUERY INFORMATION

/** Search */
function search( $search ) {
	global $_link;
	$search = $_link->real_escape_string($search);
	$predicates = [];
	if( strlen( $search ) ) {
		$query = $_link->query( "SELECT Predicate.name AS name, Predicate.arity AS arity, Predicate.short_description AS short_description, Package.name AS package, Package.slug AS slug FROM (Predicate INNER JOIN Package ON Predicate.package_id = Package.id) WHERE Package.visible = 1 and (Predicate.name LIKE '%$search%' or Predicate.short_description LIKE '%$search%') ORDER BY Predicate.name, Predicate.arity ASC" );
		while( $row = $query->fetch_assoc() )
			$predicates[] = $row;
		$query->free();
	}
	return $predicates;
}

/** Contributors */
function query_contributors() {
	global $_link;
	$query = $_link->query( "SELECT * FROM User ORDER BY id ASC" );
	$users = [];
	if( $query ) {
		while( $row = $query->fetch_assoc() )
			$users[] = $row;
		$query->free();
	}
	return $users;
}

/** Predicates */
function query_predicates() {
	global $_link;
	$query = $_link->query( "SELECT Predicate.name AS name, Predicate.arity AS arity, Predicate.short_description AS short_description, Package.name AS package, Package.slug AS slug, Category.name AS category FROM (Predicate INNER JOIN Package ON Predicate.package_id = Package.id) INNER JOIN Category ON Predicate.category_id = Category.id WHERE Package.visible = 1 ORDER BY package_id, category_id, Predicate.name, Predicate.arity ASC" );
	$predicates = [];
	$package = false;
	$category = false;
	if( $query ) {
		while( $row = $query->fetch_assoc() ) {
			if( $row["slug"] != $package ) {
				$package = $row["slug"];
				$predicates[$package] = [ "name" => $row["package"], "categories" => [] ];
				$category = false;
			}
			if( $row["category"] != $category ) {
				$category = $row["category"];
				$predicates[$package]["categories"][$category] = [];
			}
			$predicates[$package]["predicates"]["categories"][$category][] = $row;
		}
		$query->free();
	}
	return $predicates;
}

/** News */
function query_news($n) {
	global $_link;
	$query = $_link->query( "SELECT * FROM Message ORDER BY date DESC LIMIT 0,$n" );
	$news = [];
	if( $query ) {
		while( $row = $query->fetch_assoc() ) {
			$news[] = $row;
		}
		$query->free();
	}
	return $news;
}


/** Objects */
function query_objects() {
	global $_link;
	$query = $_link->query( "SELECT id, name, object_parent AS parent FROM Object ORDER BY name ASC" );
	$objects = [];
	if( $query ) {
		while( $row = $query->fetch_assoc() ) {
			if( $row["parent"] == '' ) $row["parent"] = 0;
			if( !isset( $objects[$row["parent"]] ) ) $objects[$row["parent"]] = [];
			$objects[$row["parent"]][] = $row;
		}
		$query->free();
	}
	return $objects;
}

/** Predicate by package, name and arity */
function query_predicate( $slug, $name, $arity ) {
	global $_link;
	$query = $_link->query( "SELECT Predicate.id as id, Predicate.short_description AS short_description, Predicate.long_description AS long_description, Predicate.category_id AS category, Package.name AS package, Version.name as version FROM (Predicate INNER JOIN Package ON Predicate.package_id = Package.id) INNER JOIN Version ON Predicate.version_id = Version.id WHERE Predicate.name = '$name' AND Predicate.arity = $arity AND Package.slug = '$slug'" );
	$predicate = null;
	if( $query && $query->num_rows > 0 ) {
		$predicate = $query->fetch_assoc();
		$query->free();
	}
	return $predicate;
}

/** Predicates by category */
function query_predicates_by_category( $category ) {
	global $_link;
	$query = $_link->query( "SELECT Predicate.name AS name, Predicate.arity AS arity, Package.slug AS slug FROM Predicate INNER JOIN Package ON Predicate.package_id = Package.id WHERE Predicate.category_id = $category ORDER BY Predicate.name ASC" );
	$predicates = [];
	if( $query ) {
		while( $row = $query->fetch_assoc() ) {
			$predicates[] = $row;
		}
		$query->free();
	}
	return $predicates;
}

/** Templates */
function query_templates( $id ) {
	global $_link;
	$query = $_link->query( "SELECT template FROM Template WHERE predicate_id = $id ORDER BY id ASC" );
	$templates = [];
	if( $query ) {
		while( $row = $query->fetch_assoc() )
			$templates[] = $row["template"];
		$query->free();
	}
	return $templates;
}

/** Examples */
function query_predicate_examples( $id ) {
	global $_link;
	$query = $_link->query( "SELECT description, code, date FROM Example WHERE predicate_id = $id ORDER BY date ASC" );
	$examples = [];
	if( $query ) {
		while( $row = $query->fetch_assoc() )
			$examples[] = $row;
		$query->free();
	}
	return $examples;
}

/** Modules */
function query_modules() {
	global $_link;
	$query = $_link->query( "SELECT * FROM Package WHERE visible = 1 ORDER BY id ASC" );
	$modules = [];
	if( $query ) {
		while( $row = $query->fetch_assoc() )
			$modules[] = $row;
		$query->free();
	}
	return $modules;
}

// SHOW INFORMATION

/** Search */
function show_search( $result ) {
	$str = "<div class=\"search-result\">";
	$str .= "<div class=\"search-result-name\"><a href=\"documentation/prolog/$result[slug]/" . show_predicate_uri($result["name"]) . "/$result[arity]\">$result[name]</a></div>";
	$str .= "<div class=\"search-result-description\">$result[short_description]</div>";
	$str .= "</div>";
	return $str;
}

/** Contributors */
function show_contributor( $user ) {
	$str = "<div id=\"contributor-$user[username]\" class=\"contributor\">";
	$str .= "<div class=\"contributor-left\"><img class=\"contributor-photo\" src=\"$user[image]\" alt=\"$user[complete_name]\" /></div>";
	$str .= "<div class=\"contributor-middle\"><div class=\"contributor-name\">$user[complete_name]</div>";
	$str .= "<div class=\"contributor-rol\">$user[rol]</div>";
	$str .= "<div class=\"contributor-affiliation\">$user[affiliated]</div>";
	$str .= "<div class=\"contributor-date\">Joined on: $user[joined]</div></div>";
	$str .= "<div class=\"contributor-right\">";
	$str .= "<div class=\"contributor-description\"><p>$user[description]</p></div>";
	$str .= "<div class=\"contributor-links\">";
	if( $user["url"] ) $str .= "<a href=\"http://$user[url]\" class=\"link-homepage\" target=\"_blank\">$user[url]</a> ";
	if( $user["twitter"] ) $str .= "<a href=\"https://twitter.com/$user[twitter]\" class=\"link-twitter\" target=\"_blank\">$user[twitter]</a> ";
	if( $user["github"] ) $str .= "<a href=\"https://github.com/$user[github]\" class=\"link-github\" target=\"_blank\">$user[github]</a> ";
	$str .= "</div>";
	$str .= "<div class=\"contributor-tasks\">Contributions:";
	$tasks = explode( ",", $user["contributed_on"] );
	foreach( $tasks as $task ) $str .= " <span class=\"contributor-task\">" . trim( $task ) . "</span>";
	$str .= "</div>";
	$str .= "</div>";
	$str .= "</div>";
	return $str;
}

/** Show header */
function show_header( $header ) {
	array_unshift($header, '<a href="/"><i class="fas fa-home"></i></a>');
	return implode(' <i class="fas fa-angle-double-right mx-2"></i> ', $header);
}

/** Show description */
function show_description( $desc ) {
	return preg_replace( '/\(\(([^\:]+)\:([^\)]+)\)\)/', '<a href="/documentation/prolog/$1/$2">$2</a>', str_replace( '[[', '<span class="inline-code">', str_replace( ']]', '</span>', $desc ) ) );
}

/** Show  */
function show_new( $new ) {
	return "<div class=\"new\"><span class=\"new-date\">[" . explode(" ", $new['date'])[0] . "]</span> <span class=\"new-message\">$new[message]</span></div>";
}

/** Show template */
function show_template( $template ) {
	$template = explode( '(', $template );
	$html = '<span class="predicate-template-name">' . trim( $template[0] ) . '</span>';
	if( count( $template ) > 1 ) {
		$html .= '<span class="predicate-template-paren">( </span>';
		$template = str_replace( ')', '', $template[1] );
		$args = explode( ',', $template );
		for( $i = 0; $i < count( $args ); $i++ ) {
			if( $i > 0 ) $html .= '<span class="predicate-template-paren">, </span>';
			$arg = trim( $args[$i] );
			if( $arg[0] == '+' ) $class = 'plus';
			elseif( $arg[0] == '?' ) $class = 'query';
			elseif( $arg[0] == '-' ) $class = 'minus';
			elseif( $arg[0] == '@' ) $class = 'arroba';
			elseif( $arg[0] == ':' ) $class = 'dots';
			else $class = 'generic';
			$html .= '<span class="predicate-template-argument-' . $class . '">' . $arg . '</span>';
		}
		$html .= '<span class="predicate-template-paren"> )</span>';
	}
	return '<div class="look-code mb-4 predicate-template">' . $html . '</div>';
}

/** Show objects hierarchically */
function show_hierarchical_objects( $objects, $node = 0 ) {
	if( !isset( $objects[$node] ) ) return "";
	$html = '<ul class="list-objects">';
	foreach( $objects[$node] as $object ) {
		$child = show_hierarchical_objects( $objects, $object["id"] );
		if( $child == '' ) $class = 'empty';
		else $class = 'child';
		$html .= '<li class="list-object-' . $class . '"><a href="#javascript/' . str_replace( ['()','.'], ['','/'], $object["name"] ) . '">' . $object["name"] . '</a></li>';
		$html .= $child;
	}
	$html .= '</ul>';
	return $html;
}

/** Show example */
function show_example( $example, $index, $lang = "prolog" ) {
	$html = '<div class="example" id="example-' . $index . '">';
	$html .= '<div class="example-header" id="example-' . $index . '"><h4><a href="#example-' . $index . '">Example #' . $index . '</a> ' . $example["description"] . '</h4></div>';
	$html .= '<div class="look-code">' . $example["code"] . '</div>';
	$html .= '</div>';
	return $html;
}

/** Show predicate name */
function show_predicate_name( $name ) {
	return str_replace( ['<','>','\\\\'], ['&lt;','&gt;','\\'], $name );
}

/** Show predicate uri */
function show_predicate_uri( $name ) {
	return str_replace( '\\', '%5C', $name );
}
