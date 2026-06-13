<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
 */

declare(strict_types=1);

namespace pocketmine\item;

/**
 * Every item in {@link VanillaItems} has a corresponding constant in this class. These constants can be used to
 * identify and compare item types efficiently using {@link Item::getTypeId()}.
 *
 * WARNING: These are NOT a replacement for Minecraft legacy IDs. Do **NOT** hardcode their values, or store them in
 * configs or databases. They will change without warning.
 *
 * This class is generated automatically from the item type dictionary for the current version. Do not edit it manually.
 */
final class ItemTypeIds{

    private function __construct(){
       //NOOP
    }

	public const ACACIA_BOAT = 20000;
	public const ACACIA_CHEST_BOAT = 20001;
	public const ACACIA_HANGING_SIGN = 20002;
	public const ACACIA_SIGN = 20003;
	public const AIR = 20004;
	public const AMETHYST_SHARD = 20005;
	public const ANGLER_POTTERY_SHERD = 20006;
	public const APPLE = 20007;
	public const ARCHER_POTTERY_SHERD = 20008;
	public const ARMADILLO_SCUTE = 20009;
	public const ARMOR_STAND = 20010;
	public const ARMS_POTTERY_SHERD = 20011;
	public const ARROW = 20012;
	public const AXOLOTL_BUCKET = 20013;
	public const BAKED_POTATO = 20014;
	public const BAMBOO = 20015;
	public const BAMBOO_BOAT = 20016;
	public const BAMBOO_CHEST_BOAT = 20017;
	public const BAMBOO_HANGING_SIGN = 20018;
	public const BAMBOO_SIGN = 20019;
	public const BANNER = 20020;
	public const BEETROOT = 20021;
	public const BEETROOT_SEEDS = 20022;
	public const BEETROOT_SOUP = 20023;
	public const BIRCH_BOAT = 20024;
	public const BIRCH_CHEST_BOAT = 20025;
	public const BIRCH_HANGING_SIGN = 20026;
	public const BIRCH_SIGN = 20027;
	public const BLACK_BUNDLE = 20028;
	public const BLACK_HARNESS = 20029;
	public const BLADE_POTTERY_SHERD = 20030;
	public const BLAZE_POWDER = 20031;
	public const BLAZE_ROD = 20032;
	public const BLEACH = 20033;
	public const BLUE_BUNDLE = 20034;
	public const BLUE_EGG = 20035;
	public const BLUE_HARNESS = 20036;
	public const BONE = 20037;
	public const BONE_MEAL = 20038;
	public const BOOK = 20039;
	public const BORDURE_INDENTED_BANNER_PATTERN = 20040;
	public const BOW = 20041;
	public const BOWL = 20042;
	public const BREAD = 20043;
	public const BREEZE_ROD = 20044;
	public const BREWER_POTTERY_SHERD = 20045;
	public const BRICK = 20046;
	public const BROWN_BUNDLE = 20047;
	public const BROWN_EGG = 20048;
	public const BROWN_HARNESS = 20049;
	public const BRUSH = 20050;
	public const BUCKET = 20051;
	public const BUNDLE = 20052;
	public const BURN_POTTERY_SHERD = 20053;
	public const CARROT = 20054;
	public const CARROT_ON_A_STICK = 20055;
	public const CHAINMAIL_BOOTS = 20056;
	public const CHAINMAIL_CHESTPLATE = 20057;
	public const CHAINMAIL_HELMET = 20058;
	public const CHAINMAIL_LEGGINGS = 20059;
	public const CHARCOAL = 20060;
	public const CHEMICAL_ALUMINIUM_OXIDE = 20061;
	public const CHEMICAL_AMMONIA = 20062;
	public const CHEMICAL_BARIUM_SULPHATE = 20063;
	public const CHEMICAL_BENZENE = 20064;
	public const CHEMICAL_BORON_TRIOXIDE = 20065;
	public const CHEMICAL_CALCIUM_BROMIDE = 20066;
	public const CHEMICAL_CALCIUM_CHLORIDE = 20067;
	public const CHEMICAL_CERIUM_CHLORIDE = 20068;
	public const CHEMICAL_CHARCOAL = 20069;
	public const CHEMICAL_CRUDE_OIL = 20070;
	public const CHEMICAL_GLUE = 20071;
	public const CHEMICAL_HYDROGEN_PEROXIDE = 20072;
	public const CHEMICAL_HYPOCHLORITE = 20073;
	public const CHEMICAL_INK = 20074;
	public const CHEMICAL_IRON_SULPHIDE = 20075;
	public const CHEMICAL_LATEX = 20076;
	public const CHEMICAL_LITHIUM_HYDRIDE = 20077;
	public const CHEMICAL_LUMINOL = 20078;
	public const CHEMICAL_MAGNESIUM_NITRATE = 20079;
	public const CHEMICAL_MAGNESIUM_OXIDE = 20080;
	public const CHEMICAL_MAGNESIUM_SALTS = 20081;
	public const CHEMICAL_MERCURIC_CHLORIDE = 20082;
	public const CHEMICAL_POLYETHYLENE = 20083;
	public const CHEMICAL_POTASSIUM_CHLORIDE = 20084;
	public const CHEMICAL_POTASSIUM_IODIDE = 20085;
	public const CHEMICAL_RUBBISH = 20086;
	public const CHEMICAL_SALT = 20087;
	public const CHEMICAL_SOAP = 20088;
	public const CHEMICAL_SODIUM_ACETATE = 20089;
	public const CHEMICAL_SODIUM_FLUORIDE = 20090;
	public const CHEMICAL_SODIUM_HYDRIDE = 20091;
	public const CHEMICAL_SODIUM_HYDROXIDE = 20092;
	public const CHEMICAL_SODIUM_HYPOCHLORITE = 20093;
	public const CHEMICAL_SODIUM_OXIDE = 20094;
	public const CHEMICAL_SUGAR = 20095;
	public const CHEMICAL_SULPHATE = 20096;
	public const CHEMICAL_TUNGSTEN_CHLORIDE = 20097;
	public const CHEMICAL_WATER = 20098;
	public const CHERRY_BOAT = 20099;
	public const CHERRY_CHEST_BOAT = 20100;
	public const CHERRY_HANGING_SIGN = 20101;
	public const CHERRY_SIGN = 20102;
	public const CHORUS_FRUIT = 20103;
	public const CLAY = 20104;
	public const CLOCK = 20105;
	public const CLOWNFISH = 20106;
	public const COAL = 20107;
	public const COAST_ARMOR_TRIM_SMITHING_TEMPLATE = 20108;
	public const COCOA_BEANS = 20109;
	public const COD_BUCKET = 20110;
	public const COMPASS = 20111;
	public const COOKED_CHICKEN = 20112;
	public const COOKED_FISH = 20113;
	public const COOKED_MUTTON = 20114;
	public const COOKED_PORKCHOP = 20115;
	public const COOKED_RABBIT = 20116;
	public const COOKED_SALMON = 20117;
	public const COOKIE = 20118;
	public const COPPER_AXE = 20119;
	public const COPPER_BOOTS = 20120;
	public const COPPER_CHESTPLATE = 20121;
	public const COPPER_HELMET = 20122;
	public const COPPER_HOE = 20123;
	public const COPPER_HORSE_ARMOR = 20124;
	public const COPPER_INGOT = 20125;
	public const COPPER_LEGGINGS = 20126;
	public const COPPER_NAUTILUS_ARMOR = 20127;
	public const COPPER_NUGGET = 20128;
	public const COPPER_PICKAXE = 20129;
	public const COPPER_SHOVEL = 20130;
	public const COPPER_SPEAR = 20131;
	public const COPPER_SWORD = 20132;
	public const CORAL_FAN = 20133;
	public const CREEPER_BANNER_PATTERN = 20134;
	public const CRIMSON_HANGING_SIGN = 20135;
	public const CRIMSON_SIGN = 20136;
	public const CROSSBOW = 20137;
	public const CYAN_BUNDLE = 20138;
	public const CYAN_HARNESS = 20139;
	public const DANGER_POTTERY_SHERD = 20140;
	public const DARK_OAK_BOAT = 20141;
	public const DARK_OAK_CHEST_BOAT = 20142;
	public const DARK_OAK_HANGING_SIGN = 20143;
	public const DARK_OAK_SIGN = 20144;
	public const DIAMOND = 20145;
	public const DIAMOND_AXE = 20146;
	public const DIAMOND_BOOTS = 20147;
	public const DIAMOND_CHESTPLATE = 20148;
	public const DIAMOND_HELMET = 20149;
	public const DIAMOND_HOE = 20150;
	public const DIAMOND_HORSE_ARMOR = 20151;
	public const DIAMOND_LEGGINGS = 20152;
	public const DIAMOND_NAUTILUS_ARMOR = 20153;
	public const DIAMOND_PICKAXE = 20154;
	public const DIAMOND_SHOVEL = 20155;
	public const DIAMOND_SPEAR = 20156;
	public const DIAMOND_SWORD = 20157;
	public const DISC_FRAGMENT_5 = 20158;
	public const DRAGON_BREATH = 20159;
	public const DRIED_KELP = 20160;
	public const DUNE_ARMOR_TRIM_SMITHING_TEMPLATE = 20161;
	public const DYE = 20162;
	public const ECHO_SHARD = 20163;
	public const EGG = 20164;
	public const ELYTRA = 20165;
	public const EMERALD = 20166;
	public const EMPTY_LOCATOR_MAP = 20167;
	public const EMPTY_MAP = 20168;
	public const ENCHANTED_BOOK = 20169;
	public const ENCHANTED_GOLDEN_APPLE = 20170;
	public const ENDER_EYE = 20171;
	public const ENDER_PEARL = 20172;
	public const END_CRYSTAL = 20173;
	public const EXPERIENCE_BOTTLE = 20174;
	public const EXPLORER_POTTERY_SHERD = 20175;
	public const EYE_ARMOR_TRIM_SMITHING_TEMPLATE = 20176;
	public const FEATHER = 20177;
	public const FERMENTED_SPIDER_EYE = 20178;
	public const FIELD_MASONED_BANNER_PATTERN = 20179;
	public const FIREWORK_ROCKET = 20180;
	public const FIREWORK_STAR = 20181;
	public const FIRE_CHARGE = 20182;
	public const FISHING_ROD = 20183;
	public const FLINT = 20184;
	public const FLINT_AND_STEEL = 20185;
	public const FLOWER_BANNER_PATTERN = 20186;
	public const FLOW_BANNER_PATTERN = 20187;
	public const FLOW_POTTERY_SHERD = 20188;
	public const FRIEND_POTTERY_SHERD = 20189;
	public const GHAST_TEAR = 20190;
	public const GLASS_BOTTLE = 20191;
	public const GLISTERING_MELON = 20192;
	public const GLOBE_BANNER_PATTERN = 20193;
	public const GLOWSTONE_DUST = 20194;
	public const GLOW_BERRIES = 20195;
	public const GLOW_INK_SAC = 20196;
	public const GLUSTER_POTTERY_SHERD = 20197;
	public const GOAT_HORN = 20198;
	public const GOLDEN_APPLE = 20199;
	public const GOLDEN_AXE = 20200;
	public const GOLDEN_BOOTS = 20201;
	public const GOLDEN_CARROT = 20202;
	public const GOLDEN_CHESTPLATE = 20203;
	public const GOLDEN_HELMET = 20204;
	public const GOLDEN_HOE = 20205;
	public const GOLDEN_HORSE_ARMOR = 20206;
	public const GOLDEN_LEGGINGS = 20207;
	public const GOLDEN_NAUTILUS_ARMOR = 20208;
	public const GOLDEN_PICKAXE = 20209;
	public const GOLDEN_SHOVEL = 20210;
	public const GOLDEN_SPEAR = 20211;
	public const GOLDEN_SWORD = 20212;
	public const GOLD_INGOT = 20213;
	public const GOLD_NUGGET = 20214;
	public const GRAY_BUNDLE = 20215;
	public const GRAY_HARNESS = 20216;
	public const GREEN_BUNDLE = 20217;
	public const GREEN_HARNESS = 20218;
	public const GUNPOWDER = 20219;
	public const GUSTER_BANNER_PATTERN = 20220;
	public const HEARTBREAK_POTTERY_SHERD = 20221;
	public const HEART_OF_THE_SEA = 20222;
	public const HEART_POTTERY_SHERD = 20223;
	public const HONEYCOMB = 20224;
	public const HONEY_BOTTLE = 20225;
	public const HOST_ARMOR_TRIM_SMITHING_TEMPLATE = 20226;
	public const HOWL_POTTERY_SHERD = 20227;
	public const ICE_BOMB = 20228;
	public const INK_SAC = 20229;
	public const IRON_AXE = 20230;
	public const IRON_BOOTS = 20231;
	public const IRON_CHESTPLATE = 20232;
	public const IRON_HELMET = 20233;
	public const IRON_HOE = 20234;
	public const IRON_HORSE_ARMOR = 20235;
	public const IRON_INGOT = 20236;
	public const IRON_LEGGINGS = 20237;
	public const IRON_NAUTILUS_ARMOR = 20238;
	public const IRON_NUGGET = 20239;
	public const IRON_PICKAXE = 20240;
	public const IRON_SHOVEL = 20241;
	public const IRON_SPEAR = 20242;
	public const IRON_SWORD = 20243;
	public const JUNGLE_BOAT = 20244;
	public const JUNGLE_CHEST_BOAT = 20245;
	public const JUNGLE_HANGING_SIGN = 20246;
	public const JUNGLE_SIGN = 20247;
	public const KELP = 20248;
	public const LAPIS_LAZULI = 20249;
	public const LAVA_BUCKET = 20250;
	public const LEAD = 20251;
	public const LEATHER = 20252;
	public const LEATHER_BOOTS = 20253;
	public const LEATHER_CAP = 20254;
	public const LEATHER_HORSE_ARMOR = 20255;
	public const LEATHER_PANTS = 20256;
	public const LEATHER_TUNIC = 20257;
	public const LIGHT_BLUE_BUNDLE = 20258;
	public const LIGHT_BLUE_HARNESS = 20259;
	public const LIGHT_GRAY_BUNDLE = 20260;
	public const LIGHT_GRAY_HARNESS = 20261;
	public const LIME_BUNDLE = 20262;
	public const LIME_HARNESS = 20263;
	public const LINGERING_POTION = 20264;
	public const MACE = 20265;
	public const MAGENTA_BUNDLE = 20266;
	public const MAGENTA_HARNESS = 20267;
	public const MAGMA_CREAM = 20268;
	public const MANGROVE_BOAT = 20269;
	public const MANGROVE_CHEST_BOAT = 20270;
	public const MANGROVE_HANGING_SIGN = 20271;
	public const MANGROVE_SIGN = 20272;
	public const MEDICINE = 20273;
	public const MELON = 20274;
	public const MELON_SEEDS = 20275;
	public const MILK_BUCKET = 20276;
	public const MINECART = 20277;
	public const MINER_POTTERY_SHERD = 20278;
	public const MOURNER_POTTERY_SHERD = 20279;
	public const MUSHROOM_STEW = 20280;
	public const NAME_TAG = 20281;
	public const NAUTILUS_SHELL = 20282;
	public const NETHERITE_AXE = 20283;
	public const NETHERITE_BOOTS = 20284;
	public const NETHERITE_CHESTPLATE = 20285;
	public const NETHERITE_HELMET = 20286;
	public const NETHERITE_HOE = 20287;
	public const NETHERITE_HORSE_ARMOR = 20288;
	public const NETHERITE_INGOT = 20289;
	public const NETHERITE_LEGGINGS = 20290;
	public const NETHERITE_NAUTILUS_ARMOR = 20291;
	public const NETHERITE_PICKAXE = 20292;
	public const NETHERITE_SCRAP = 20293;
	public const NETHERITE_SHOVEL = 20294;
	public const NETHERITE_SPEAR = 20295;
	public const NETHERITE_SWORD = 20296;
	public const NETHERITE_UPGRADE_SMITHING_TEMPLATE = 20297;
	public const NETHER_BRICK = 20298;
	public const NETHER_QUARTZ = 20299;
	public const NETHER_STAR = 20300;
	public const OAK_BOAT = 20301;
	public const OAK_CHEST_BOAT = 20302;
	public const OAK_HANGING_SIGN = 20303;
	public const OAK_SIGN = 20304;
	public const OMINOUS_BANNER = 20305;
	public const OMINOUS_BOTTLE = 20306;
	public const OMINOUS_TRIAL_KEY = 20307;
	public const ORANGE_BUNDLE = 20308;
	public const ORANGE_HARNESS = 20309;
	public const PAINTING = 20310;
	public const PALE_OAK_BOAT = 20311;
	public const PALE_OAK_CHEST_BOAT = 20312;
	public const PALE_OAK_HANGING_SIGN = 20313;
	public const PALE_OAK_SIGN = 20314;
	public const PAPER = 20315;
	public const PHANTOM_MEMBRANE = 20316;
	public const PINK_BUNDLE = 20317;
	public const PINK_HARNESS = 20318;
	public const PITCHER_POD = 20319;
	public const PLENTY_POTTERY_SHERD = 20320;
	public const POISONOUS_POTATO = 20321;
	public const POPPED_CHORUS_FRUIT = 20322;
	public const POTATO = 20323;
	public const POTION = 20324;
	public const POWDER_SNOW_BUCKET = 20325;
	public const PRISMARINE_CRYSTALS = 20326;
	public const PRISMARINE_SHARD = 20327;
	public const PRIZE_POTTERY_SHERD = 20328;
	public const PUFFERFISH = 20329;
	public const PUFFERFISH_BUCKET = 20330;
	public const PUMPKIN_PIE = 20331;
	public const PUMPKIN_SEEDS = 20332;
	public const PURPLE_BUNDLE = 20333;
	public const PURPLE_HARNESS = 20334;
	public const RABBIT_FOOT = 20335;
	public const RABBIT_HIDE = 20336;
	public const RABBIT_STEW = 20337;
	public const RAISER_ARMOR_TRIM_SMITHING_TEMPLATE = 20338;
	public const RAW_BEEF = 20339;
	public const RAW_CHICKEN = 20340;
	public const RAW_COPPER = 20341;
	public const RAW_FISH = 20342;
	public const RAW_GOLD = 20343;
	public const RAW_IRON = 20344;
	public const RAW_MUTTON = 20345;
	public const RAW_PORKCHOP = 20346;
	public const RAW_RABBIT = 20347;
	public const RAW_SALMON = 20348;
	public const RECORD_11 = 20349;
	public const RECORD_13 = 20350;
	public const RECORD_5 = 20351;
	public const RECORD_BLOCKS = 20352;
	public const RECORD_CAT = 20353;
	public const RECORD_CHIRP = 20354;
	public const RECORD_CREATOR = 20355;
	public const RECORD_CREATOR_MUSIC_BOX = 20356;
	public const RECORD_FAR = 20357;
	public const RECORD_LAVA_CHICKEN = 20358;
	public const RECORD_MALL = 20359;
	public const RECORD_MELLOHI = 20360;
	public const RECORD_OTHERSIDE = 20361;
	public const RECORD_PIGSTEP = 20362;
	public const RECORD_PRECIPICE = 20363;
	public const RECORD_RELIC = 20364;
	public const RECORD_STAL = 20365;
	public const RECORD_STRAD = 20366;
	public const RECORD_WAIT = 20367;
	public const RECORD_WARD = 20368;
	public const RECOVERY_COMPASS = 20369;
	public const REDSTONE_DUST = 20370;
	public const RED_BUNDLE = 20371;
	public const RED_HARNESS = 20372;
	public const RESIN_BRICK = 20373;
	public const RIB_ARMOR_TRIM_SMITHING_TEMPLATE = 20374;
	public const ROTTEN_FLESH = 20375;
	public const SADDLE = 20376;
	public const SALMON_BUCKET = 20377;
	public const SCRAPE_POTTERY_SHERD = 20378;
	public const SCUTE = 20379;
	public const SENTRY_ARMOR_TRIM_SMITHING_TEMPLATE = 20380;
	public const SHAPER_ARMOR_TRIM_SMITHING_TEMPLATE = 20381;
	public const SHEAF_POTTERY_SHERD = 20382;
	public const SHEARS = 20383;
	public const SHELTER_POTTERY_SHERD = 20384;
	public const SHIELD = 20385;
	public const SHULKER_SHELL = 20386;
	public const SILENCE_ARMOR_TRIM_SMITHING_TEMPLATE = 20387;
	public const SKULL_BANNER_PATTERN = 20388;
	public const SKULL_POTTERY_SHERD = 20389;
	public const SLIMEBALL = 20390;
	public const SNORT_POTTERY_SHERD = 20391;
	public const SNOUT_ARMOR_TRIM_SMITHING_TEMPLATE = 20392;
	public const SNOWBALL = 20393;
	public const SPIDER_EYE = 20394;
	public const SPIRE_ARMOR_TRIM_SMITHING_TEMPLATE = 20395;
	public const SPLASH_POTION = 20396;
	public const SPRUCE_BOAT = 20397;
	public const SPRUCE_CHEST_BOAT = 20398;
	public const SPRUCE_HANGING_SIGN = 20399;
	public const SPRUCE_SIGN = 20400;
	public const SPYGLASS = 20401;
	public const SQUID_SPAWN_EGG = 20402;
	public const STEAK = 20403;
	public const STICK = 20404;
	public const STONE_AXE = 20405;
	public const STONE_HOE = 20406;
	public const STONE_PICKAXE = 20407;
	public const STONE_SHOVEL = 20408;
	public const STONE_SPEAR = 20409;
	public const STONE_SWORD = 20410;
	public const STRING = 20411;
	public const SUGAR = 20412;
	public const SUSPICIOUS_STEW = 20413;
	public const SWEET_BERRIES = 20414;
	public const TADPOLE_BUCKET = 20415;
	public const THING_BANNER_PATTERN = 20416;
	public const TIDE_ARMOR_TRIM_SMITHING_TEMPLATE = 20417;
	public const TORCHFLOWER_SEEDS = 20418;
	public const TOTEM = 20419;
	public const TRIAL_KEY = 20420;
	public const TRIDENT = 20421;
	public const TROPICAL_FISH_BUCKET = 20422;
	public const TURTLE_HELMET = 20423;
	public const VEX_ARMOR_TRIM_SMITHING_TEMPLATE = 20424;
	public const VILLAGER_SPAWN_EGG = 20425;
	public const WARD_ARMOR_TRIM_SMITHING_TEMPLATE = 20426;
	public const WARPED_FUNGUS_ON_A_STICK = 20427;
	public const WARPED_HANGING_SIGN = 20428;
	public const WARPED_SIGN = 20429;
	public const WATER_BUCKET = 20430;
	public const WAYFINDER_ARMOR_TRIM_SMITHING_TEMPLATE = 20431;
	public const WHEAT = 20432;
	public const WHEAT_SEEDS = 20433;
	public const WHITE_BUNDLE = 20434;
	public const WHITE_HARNESS = 20435;
	public const WILD_ARMOR_TRIM_SMITHING_TEMPLATE = 20436;
	public const WIND_CHARGE = 20437;
	public const WOLF_ARMOR = 20438;
	public const WOODEN_AXE = 20439;
	public const WOODEN_HOE = 20440;
	public const WOODEN_PICKAXE = 20441;
	public const WOODEN_SHOVEL = 20442;
	public const WOODEN_SPEAR = 20443;
	public const WOODEN_SWORD = 20444;
	public const WRITABLE_BOOK = 20445;
	public const WRITTEN_BOOK = 20446;
	public const YELLOW_BUNDLE = 20447;
	public const YELLOW_HARNESS = 20448;
	public const ZOMBIE_SPAWN_EGG = 20449;

    public const FIRST_UNUSED_ITEM_ID = 20450;
    
    private static int $nextDynamicId = self::FIRST_UNUSED_ITEM_ID;
    
    /**
     * Returns a new runtime item type ID, e.g. for use by a custom item.
     */
    public static function newId() : int{
       return self::$nextDynamicId++;
    }
    
    public static function fromBlockTypeId(int $blockTypeId) : int{
       if($blockTypeId < 0){
          throw new \InvalidArgumentException("Block type IDs cannot be negative");
       }
       //negative item type IDs are treated as block IDs
       return -$blockTypeId;
    }
    
    public static function toBlockTypeId(int $itemTypeId) : ?int{
       if($itemTypeId > 0){ //not a blockitem
          return null;
       }
       return -$itemTypeId;
    }
}
