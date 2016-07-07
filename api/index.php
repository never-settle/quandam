<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/" . explode("/", dirname($_SERVER['PHP_SELF']))[1] . "/app/config.php";

/*

	A script that routes requests to controller

	Routing

	Author: Patrick Notar

*/

$request = $_GET["request"] ?? "";
$field = $_GET["field"] ?? "";

if (strcmp($_SERVER["REQUEST_METHOD"], "GET") === 0) {

    switch ($request) {


        // Ability
        // ----------------------------------------------------------------------------------------
        case "all-abilities": {
            $handler = new AbilityRestController();
            $handler->getAllAbilities();
            break;
        }

        case "ability": {
            $handler = new AbilityRestController();
            if (!$field) {
                $handler->getAbility($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Achievement
        // ----------------------------------------------------------------------------------------
        case "all-achievements": {
            $handler = new AchievementRestController();
            $handler->getAllAchievements();
            break;
        }

        case "achievement": {
            $handler = new AchievementRestController();
            if (!$field) {
                $handler->getAchievement($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Goal
        // ----------------------------------------------------------------------------------------
        case "all-goals": {
            $handler = new GoalRestController();
            $handler->getAllGoals();
            break;
        }

        case "goal": {
            $handler = new GoalRestController();
            if (!$field) {
                $handler->getGoal($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Grade
        // ----------------------------------------------------------------------------------------
        case "all-grades": {
            $handler = new GradeRestController();
            $handler->getAllGrades();
            break;
        }

        case "grade": {
            $handler = new GradeRestController();
            if (!$field) {
                $handler->getGrade($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Level
        // ----------------------------------------------------------------------------------------
        case "all-levels": {
            $handler = new LevelRestController();
            $handler->getAllLevels();
            break;
        }

        case "level": {
            $handler = new LevelRestController();
            if (!$field) {
                $handler->getLevel($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Mentor
        // ----------------------------------------------------------------------------------------
        case "all-mentors": {
            $handler = new MentorRestController();
            $handler->getAllMentors();
            break;
        }

        case "mentor": {
            $handler = new MentorRestController();
            if (!$field) {
                $handler->getMentor($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Mentorhassubject
        // ----------------------------------------------------------------------------------------
        case "all-mentorhassubjects": {
            $handler = new MentorhassubjectRestController();
            $handler->getAllMentorhassubjects();
            break;
        }

        case "mentorhassubject": {
            $handler = new MentorhassubjectRestController();
            if (!$field) {
                $handler->getMentorhassubject($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Parent
        // ----------------------------------------------------------------------------------------
        case "all-parents": {
            $handler = new ParentRestController();
            $handler->getAllParents();
            break;
        }

        case "parent": {
            $handler = new ParentRestController();
            if (!$field) {
                $handler->getParent($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Parenthasstudent
        // ----------------------------------------------------------------------------------------
        case "all-parenthasstudents": {
            $handler = new ParenthasstudentRestController();
            $handler->getAllParenthasstudents();
            break;
        }

        case "parenthasstudent": {
            $handler = new ParenthasstudentRestController();
            if (!$field) {
                $handler->getParenthasstudent($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Schoolclass
        // ----------------------------------------------------------------------------------------
        case "all-schoolclasses": {
            $handler = new SchoolclassRestController();
            $handler->getAllSchoolclasses();
            break;
        }

        case "schoolclass": {
            $handler = new SchoolclassRestController();
            if (!$field) {
                $handler->getSchoolclass($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Student
        // ----------------------------------------------------------------------------------------
        case "all-students": {
            $handler = new StudentRestController();
            $handler->getAllStudents();
            break;
        }

        case "student": {
            $handler = new StudentRestController();
            if (!$field) {
                $handler->getStudent($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Studenthasability
        // ----------------------------------------------------------------------------------------
        case "all-studenthasabilities": {
            $handler = new StudenthasabilityRestController();
            $handler->getAllStudenthasabilities();
            break;
        }

        case "studenthasability": {
            $handler = new StudenthasabilityRestController();
            if (!$field) {
                $handler->getStudenthasability($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Studenthasachievement
        // ----------------------------------------------------------------------------------------
        case "all-studenthasachievements": {
            $handler = new StudenthasachievementRestController();
            $handler->getAllStudenthasachievements();
            break;
        }

        case "studenthasachievement": {
            $handler = new StudenthasachievementRestController();
            if (!$field) {
                $handler->getStudenthasachievement($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Studenthasgoal
        // ----------------------------------------------------------------------------------------
        case "all-studenthasgoals": {
            $handler = new StudenthasgoalRestController();
            $handler->getAllStudenthasgoals();
            break;
        }

        case "studenthasgoal": {
            $handler = new StudenthasgoalRestController();
            if (!$field) {
                $handler->getStudenthasgoal($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Studenthasmentor
        // ----------------------------------------------------------------------------------------
        case "all-studenthasmentors": {
            $handler = new StudenthasmentorRestController();
            $handler->getAllStudenthasmentors();
            break;
        }

        case "studenthasmentor": {
            $handler = new StudenthasmentorRestController();
            if (!$field) {
                $handler->getStudenthasmentor($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Studenthassubject
        // ----------------------------------------------------------------------------------------
        case "all-studenthassubjects": {
            $handler = new StudenthassubjectRestController();
            $handler->getAllStudenthassubjects();
            break;
        }

        case "studenthassubject": {
            $handler = new StudenthassubjectRestController();
            if (!$field) {
                $handler->getStudenthassubject($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Subject
        // ----------------------------------------------------------------------------------------
        case "all-subjects": {
            $handler = new SubjectRestController();
            $handler->getAllSubjects();
            break;
        }

        case "subject": {
            $handler = new SubjectRestController();
            if (!$field) {
                $handler->getSubject($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // User
        // ----------------------------------------------------------------------------------------
        case "all-users": {
            $handler = new UserRestController();
            $handler->getAllUsers();
            break;
        }

        case "user": {
            $handler = new UserRestController();
            if (!$field) {
                $handler->getUser($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Userhasmessage
        // ----------------------------------------------------------------------------------------
        case "all-userhasmessages": {
            $handler = new UserhasmessageRestController();
            $handler->getAllUserhasmessages();
            break;
        }

        case "userhasmessage": {
            $handler = new UserhasmessageRestController();
            if (!$field) {
                $handler->getUserhasmessage($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        case "" : {
            //404 - not found;
            break;
        }
    }
}