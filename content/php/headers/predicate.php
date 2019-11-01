<?php

$_title = $_GET["predicate"] . "/" . $_GET["arity"] . ' - Manual';
$_header = ["<a href=\"/documentation\">Documentation</a>", "<a href=\"/documentation#prolog\">Prolog Predicate Reference</a>", "<a href=\"/documentation#$_GET[package]\">$_GET[package]</a>", show_predicate_name( $_GET["predicate"] ) . "/" . $_GET["arity"]];
$_description = $_GET["predicate"] . "/" . $_GET["arity"] . ' - Manual';
